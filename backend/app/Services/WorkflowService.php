<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Stage;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WorkflowService
{
    /**
     * Create a stage automatically when an application is accepted.
     */
    public function createStageFromApplication(Application $application): ?Stage
    {
        try {
            // Find available supervisor
            $supervisor = $this->findAvailableSupervisor($application->offer->department);

            if (!$supervisor) {
                Log::warning("No available supervisor found for department: {$application->offer->department}");
                // Create stage without supervisor for now
                $supervisorId = null;
            } else {
                $supervisorId = $supervisor->user->id;
            }

            // Calculate stage dates based on offer duration
            $startDate = now()->addDays(30); // Start in 30 days by default
            $endDate = $startDate->copy()->addMonths($application->offer->duration_months ?? 6);

            $stage = Stage::create([
                'student_id' => $application->student_id,
                'application_id' => $application->id,
                'supervisor_id' => $supervisorId,
                'offer_id' => $application->offer_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'planned',
                'progress_percentage' => 0,
                'objectives' => $this->generateDefaultObjectives($application),
                'weekly_hours' => 35, // Default 35 hours/week
                'compensation' => $application->offer->compensation ?? 0,
                'location' => $application->offer->location,
            ]);

            Log::info("Stage created automatically for application {$application->id}: Stage {$stage->id}");

            return $stage;
        } catch (\Exception $e) {
            Log::error("Failed to create stage from application {$application->id}: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * Assign supervisor to a stage.
     */
    public function assignSupervisorToStage(Stage $stage, User $supervisor): bool
    {
        try {
            if (!$supervisor->hasRole('supervisor')) {
                throw new \InvalidArgumentException('User is not a supervisor.');
            }

            $stage->assignSupervisor($supervisor);

            Log::info("Supervisor {$supervisor->id} assigned to stage {$stage->id}");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to assign supervisor to stage {$stage->id}: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Start a planned stage.
     */
    public function startStage(Stage $stage): bool
    {
        try {
            if ($stage->status !== 'planned') {
                throw new \InvalidArgumentException('Stage is not in planned status.');
            }

            $stage->update([
                'status' => 'active',
                'start_date' => now(),
            ]);

            Log::info("Stage {$stage->id} started");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to start stage {$stage->id}: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Complete a stage automatically when evaluation is finalized.
     */
    public function completeStageOnEvaluation(Stage $stage): bool
    {
        try {
            // Check if stage has final evaluation
            $hasFinalEvaluation = $stage->evaluations()
                ->where('evaluation_type', 'final')
                ->where('is_draft', false)
                ->exists();

            if ($hasFinalEvaluation && $stage->status === 'active') {
                $stage->complete();
                Log::info("Stage {$stage->id} completed automatically after final evaluation");
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error("Failed to complete stage {$stage->id}: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Handle stage deadline approaching.
     */
    public function handleDeadlineApproaching(Stage $stage, int $daysLeft): void
    {
        try {
            if ($daysLeft <= 7 && $stage->status === 'active') {
                // Send reminders to all parties
                $this->sendDeadlineReminders($stage, $daysLeft);
            }

            if ($daysLeft <= 0 && $stage->status === 'active') {
                // Auto-complete overdue stages
                $stage->update(['status' => 'completed']);
                Log::info("Stage {$stage->id} auto-completed due to deadline");
            }
        } catch (\Exception $e) {
            Log::error("Failed to handle deadline for stage {$stage->id}: {$e->getMessage()}");
        }
    }

    /**
     * Extend stage duration.
     */
    public function extendStageDuration(Stage $stage, int $additionalMonths, string $reason): bool
    {
        try {
            $newEndDate = $stage->end_date->copy()->addMonths($additionalMonths);

            $stage->extendEndDate($newEndDate);

            Log::info("Stage {$stage->id} extended by {$additionalMonths} months. Reason: {$reason}");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to extend stage {$stage->id}: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Process bulk stage operations.
     */
    public function bulkStartStages(array $stageIds): array
    {
        $results = ['started' => 0, 'failed' => 0];

        foreach ($stageIds as $stageId) {
            $stage = Stage::find($stageId);
            if ($stage && $this->startStage($stage)) {
                $results['started']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    /**
     * Find available supervisor for a department.
     */
    private function findAvailableSupervisor(?string $department): ?Supervisor
    {
        return Supervisor::available()
            ->when($department, fn($q) => $q->where('department', $department))
            ->orderBy('available_slots', 'desc')
            ->first();
    }

    /**
     * Generate default objectives for a stage.
     */
    private function generateDefaultObjectives(Application $application): array
    {
        return [
            'Complete required training modules',
            'Participate in team projects',
            'Learn company-specific tools and processes',
            'Contribute to real-world projects',
            'Receive mentorship and feedback',
            'Develop professional skills in ' . ($application->offer->department ?? 'the field'),
        ];
    }

    /**
     * Send deadline reminders to all parties.
     */
    private function sendDeadlineReminders(Stage $stage, int $daysLeft): void
    {
        $message = "The internship for {$stage->student->name} at {$stage->offer->company->company_name} ends in {$daysLeft} days.";

        // Notify student
        app(NotificationService::class)->createNotification(
            $stage->student,
            'Internship Ending Soon',
            $message,
            'deadline_warning',
            $stage,
            'high'
        );

        // Notify supervisor
        if ($stage->supervisor) {
            app(NotificationService::class)->createNotification(
                $stage->supervisor,
                'Internship Ending Soon',
                $message,
                'deadline_warning',
                $stage,
                'high'
            );
        }

        // Notify company
        app(NotificationService::class)->createNotification(
            $stage->offer->company->user,
            'Internship Ending Soon',
            $message,
            'deadline_warning',
            $stage,
            'medium'
        );
    }

    /**
     * Process automatic stage transitions.
     */
    public function processAutomaticTransitions(): array
    {
        $transitions = ['started' => 0, 'completed' => 0];

        // Start planned stages that are ready
        $readyStages = Stage::where('status', 'planned')
            ->where('start_date', '<=', now())
            ->get();

        foreach ($readyStages as $stage) {
            if ($this->startStage($stage)) {
                $transitions['started']++;
            }
        }

        // Complete overdue stages
        $overdueStages = Stage::where('status', 'active')
            ->where('end_date', '<', now())
            ->get();

        foreach ($overdueStages as $stage) {
            $stage->complete();
            $transitions['completed']++;
        }

        return $transitions;
    }

    /**
     * Validate stage data before creation.
     */
    public function validateStageData(array $data): array
    {
        $errors = [];

        if (isset($data['start_date']) && isset($data['end_date'])) {
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);

            if ($endDate->lte($startDate)) {
                $errors[] = 'End date must be after start date.';
            }

            $durationMonths = $startDate->diffInMonths($endDate);
            if ($durationMonths < 3 || $durationMonths > 12) {
                $errors[] = 'Internship duration must be between 3 and 12 months.';
            }
        }

        if (isset($data['supervisor_id'])) {
            $supervisor = User::find($data['supervisor_id']);
            if (!$supervisor || !$supervisor->hasRole('supervisor')) {
                $errors[] = 'Invalid supervisor selected.';
            }
        }

        return $errors;
    }
}
