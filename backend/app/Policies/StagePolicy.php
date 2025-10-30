<?php

namespace App\Policies;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any stages.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('student') || $user->hasRole('company') || $user->hasRole('supervisor') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the stage.
     */
    public function view(User $user, Stage $stage): bool
    {
        // Student can view their own stages
        if ($user->hasRole('student') && $stage->student_id === $user->id) {
            return true;
        }

        // Company can view stages for their offers
        if ($user->hasRole('company') && $stage->offer->company_id === $user->company->id) {
            return true;
        }

        // Supervisor can view stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Admin can view all stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create stages.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('company') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the stage.
     */
    public function update(User $user, Stage $stage): bool
    {
        // Supervisor can update stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Company can update stages for their offers
        if ($user->hasRole('company') && $stage->offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can update all stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the stage.
     */
    public function delete(User $user, Stage $stage): bool
    {
        // Admin can delete stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can assign supervisor to stage.
     */
    public function assignSupervisor(User $user, Stage $stage): bool
    {
        return $user->hasRole('admin') || $user->hasRole('company') && $stage->offer->company_id === $user->company->id;
    }

    /**
     * Determine whether the user can evaluate the stage.
     */
    public function evaluate(User $user, Stage $stage): bool
    {
        // Supervisor can evaluate stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Admin can evaluate all stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can complete the stage.
     */
    public function complete(User $user, Stage $stage): bool
    {
        // Supervisor can complete stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Company can complete stages for their offers
        if ($user->hasRole('company') && $stage->offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can complete all stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can extend the stage.
     */
    public function extend(User $user, Stage $stage): bool
    {
        // Supervisor can extend stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Company can extend stages for their offers
        if ($user->hasRole('company') && $stage->offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can extend all stages
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view stage documents.
     */
    public function viewDocuments(User $user, Stage $stage): bool
    {
        return $this->view($user, $stage);
    }

    /**
     * Determine whether the user can upload documents to stage.
     */
    public function uploadDocuments(User $user, Stage $stage): bool
    {
        // Student can upload to their own stages
        if ($user->hasRole('student') && $stage->student_id === $user->id) {
            return true;
        }

        // Supervisor can upload to stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can review documents in stage.
     */
    public function reviewDocuments(User $user, Stage $stage): bool
    {
        // Supervisor can review documents for stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Company can review documents for their offers' stages
        if ($user->hasRole('company') && $stage->offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can review all documents
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view stage evaluations.
     */
    public function viewEvaluations(User $user, Stage $stage): bool
    {
        return $this->view($user, $stage);
    }

    /**
     * Determine whether the user can create evaluations for the stage.
     */
    public function createEvaluation(User $user, Stage $stage): bool
    {
        return $this->evaluate($user, $stage);
    }

    /**
     * Determine whether the user can update stage progress.
     */
    public function updateProgress(User $user, Stage $stage): bool
    {
        // Supervisor can update progress for stages they supervise
        if ($user->hasRole('supervisor') && $stage->supervisor_id === $user->id) {
            return true;
        }

        // Student can update their own progress (limited)
        if ($user->hasRole('student') && $stage->student_id === $user->id) {
            return true;
        }

        return false;
    }
}
