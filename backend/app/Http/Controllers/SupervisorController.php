<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Stage;
use App\Models\Evaluation;
use App\Models\Notification;
use App\Models\Message;
use App\Http\Requests\StoreEvaluationRequest;
use App\Services\NotificationService;

class SupervisorController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware('auth:api');
        $this->middleware('role:supervisor');
    }

    /**
     * Display the supervisor dashboard.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = Auth::user();
        $supervisor = $user->supervisor;

        $stages = $user->supervisor->stages();
        $activeStages = $stages->active();
        $evaluations = $user->supervisor->evaluations();

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => [
                    'id' => $supervisor->id ?? null,
                    'name' => $user->name,
                    'email' => $user->email,
                    'department' => $supervisor->department ?? null,
                    'specialization' => $supervisor->specialization ?? null,
                    'available_slots' => $supervisor->available_slots ?? 0,
                ],
                'stats' => [
                    'total_stages' => $stages->count(),
                    'active_stages' => $activeStages->count(),
                    'completed_stages' => $stages->completed()->count(),
                    'total_evaluations' => $evaluations->count(),
                    'pending_evaluations' => $evaluations->drafts()->count(),
                ],
                'recent_stages' => $activeStages->with(['student.student', 'offer.company'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ],
        ]);
    }

    /**
     * Get supervisor's stages.
     */
    public function stages(Request $request): JsonResponse
    {
        $stages = Auth::user()->supervisor->stages()
            ->with(['student.student', 'offer.company', 'evaluations'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->student_id, fn($q) => $q->where('student_id', $request->student_id))
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $stages,
        ]);
    }

    /**
     * Show stage details.
     */
    public function showStage(Stage $stage): JsonResponse
    {
        Gate::authorize('view', $stage);

        $stage->load([
            'student.student',
            'offer.company',
            'documents',
            'evaluations.evaluator'
        ]);

        return response()->json([
            'success' => true,
            'data' => $stage,
        ]);
    }

    /**
     * Update stage details.
     */
    public function updateStage(Request $request, Stage $stage): JsonResponse
    {
        Gate::authorize('update', $stage);

        $request->validate([
            'objectives' => 'nullable|array',
            'weekly_hours' => 'nullable|integer|min:1|max:60',
            'location' => 'nullable|string|max:255',
            'supervisor_notes' => 'nullable|string|max:1000',
        ]);

        $stage->update($request->only([
            'objectives',
            'weekly_hours',
            'location',
            'supervisor_notes'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Stage updated successfully.',
            'data' => $stage,
        ]);
    }

    /**
     * Extend stage end date.
     */
    public function extendStage(Request $request, Stage $stage): JsonResponse
    {
        Gate::authorize('update', $stage);

        $request->validate([
            'new_end_date' => 'required|date|after:today',
            'reason' => 'required|string|max:500',
        ]);

        $stage->extendEndDate($request->new_end_date);

        // Notify student and company
        $this->notificationService->createNotification(
            $stage->student,
            'Stage Extended',
            "Your internship end date has been extended to {$request->new_end_date}. Reason: {$request->reason}",
            'stage_update',
            $stage
        );

        $this->notificationService->createNotification(
            $stage->offer->company->user,
            'Stage Extended',
            "The internship end date for {$stage->student->name} has been extended to {$request->new_end_date}.",
            'stage_update',
            $stage
        );

        return response()->json([
            'success' => true,
            'message' => 'Stage extended successfully.',
            'data' => $stage,
        ]);
    }

    /**
     * Create evaluation.
     */
    public function createEvaluation(StoreEvaluationRequest $request, Stage $stage): JsonResponse
    {
        Gate::authorize('evaluate', $stage);

        $evaluation = Evaluation::create(array_merge($request->validated(), [
            'stage_id' => $stage->id,
            'evaluator_id' => Auth::id(),
            'evaluatee_id' => $stage->student_id,
            'evaluation_type' => $request->evaluation_type ?? 'monthly',
            'is_draft' => $request->boolean('save_as_draft', false),
        ]));

        if (!$evaluation->is_draft) {
            $evaluation->publish();

            // Notify student
            $this->notificationService->createNotification(
                $stage->student,
                'New Evaluation',
                "You have received a new {$evaluation->evaluation_type} evaluation.",
                'evaluation',
                $evaluation
            );

            // Notify company
            $this->notificationService->createNotification(
                $stage->offer->company->user,
                'New Evaluation',
                "A new {$evaluation->evaluation_type} evaluation has been created for {$stage->student->name}.",
                'evaluation',
                $evaluation
            );
        }

        return response()->json([
            'success' => true,
            'message' => $evaluation->is_draft ? 'Evaluation saved as draft.' : 'Evaluation published successfully.',
            'data' => $evaluation,
        ], 201);
    }

    /**
     * Get evaluations for stages.
     */
    public function evaluations(Request $request): JsonResponse
    {
        $evaluations = Auth::user()->supervisor->evaluations()
            ->with(['stage.student.student', 'stage.offer.company'])
            ->when($request->evaluation_type, fn($q) => $q->where('evaluation_type', $request->evaluation_type))
            ->when($request->boolean('drafts_only'), fn($q) => $q->drafts())
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $evaluations,
        ]);
    }

    /**
     * Show evaluation details.
     */
    public function showEvaluation(Evaluation $evaluation): JsonResponse
    {
        Gate::authorize('view', $evaluation);

        $evaluation->load([
            'stage.student.student',
            'stage.offer.company',
            'evaluator'
        ]);

        return response()->json([
            'success' => true,
            'data' => $evaluation,
        ]);
    }

    /**
     * Update evaluation.
     */
    public function updateEvaluation(Request $request, Evaluation $evaluation): JsonResponse
    {
        Gate::authorize('update', $evaluation);

        if (!$evaluation->is_draft) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update published evaluation.',
            ], 400);
        }

        $evaluation->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Evaluation updated successfully.',
            'data' => $evaluation,
        ]);
    }

    /**
     * Publish draft evaluation.
     */
    public function publishEvaluation(Evaluation $evaluation): JsonResponse
    {
        Gate::authorize('update', $evaluation);

        if (!$evaluation->is_draft) {
            return response()->json([
                'success' => false,
                'message' => 'Evaluation is already published.',
            ], 400);
        }

        $evaluation->publish();

        // Notify relevant parties
        $this->notificationService->createNotification(
            $evaluation->evaluatee,
            'Evaluation Published',
            "Your {$evaluation->evaluation_type} evaluation has been published.",
            'evaluation',
            $evaluation
        );

        return response()->json([
            'success' => true,
            'message' => 'Evaluation published successfully.',
            'data' => $evaluation,
        ]);
    }

    /**
     * Get available supervisors (for admin use).
     */
    public function availableSupervisors(Request $request): JsonResponse
    {
        $supervisors = Supervisor::available()
            ->with('user')
            ->when($request->department, fn($q) => $q->where('department', $request->department))
            ->get()
            ->map(function ($supervisor) {
                return [
                    'id' => $supervisor->user->id,
                    'name' => $supervisor->user->name,
                    'email' => $supervisor->user->email,
                    'department' => $supervisor->department,
                    'available_slots' => $supervisor->available_slots,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $supervisors,
        ]);
    }

    /**
     * Get notifications.
     */
    public function notifications(Request $request): JsonResponse
    {
        $notifications = Auth::user()->notifications()
            ->when($request->boolean('unread_only'), fn($q) => $q->unread())
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markNotificationAsRead(Notification $notification): JsonResponse
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Get messages.
     */
    public function messages(Request $request): JsonResponse
    {
        $messages = Message::betweenUsers(Auth::id(), $request->other_user_id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * Send message.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
            'stage_id' => 'nullable|exists:stages,id',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'stage_id' => $request->stage_id,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $message->load(['sender', 'receiver']),
        ], 201);
    }
}
