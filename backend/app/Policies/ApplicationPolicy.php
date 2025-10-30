<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('student') || $user->hasRole('company') || $user->hasRole('supervisor') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the application.
     */
    public function view(User $user, Application $application): bool
    {
        // Student can view their own applications
        if ($user->hasRole('student') && $application->student_id === $user->id) {
            return true;
        }

        // Company can view applications for their offers
        if ($user->hasRole('company') && $application->offer->company_id === $user->company->id) {
            return true;
        }

        // Supervisor can view applications for stages they're supervising
        if ($user->hasRole('supervisor') && $application->stage && $application->stage->supervisor_id === $user->id) {
            return true;
        }

        // Admin can view all applications
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create applications.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('student');
    }

    /**
     * Determine whether the user can update the application.
     */
    public function update(User $user, Application $application): bool
    {
        // Student can update their own pending applications
        return $user->hasRole('student') &&
               $application->student_id === $user->id &&
               $application->status === 'pending';
    }

    /**
     * Determine whether the user can delete the application.
     */
    public function delete(User $user, Application $application): bool
    {
        // Student can withdraw their own applications
        if ($user->hasRole('student') && $application->student_id === $user->id) {
            return $application->status === 'pending' || $application->status === 'rejected';
        }

        // Admin can delete any application
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can review/accept/reject the application.
     */
    public function review(User $user, Application $application): bool
    {
        // Company can review applications for their offers
        if ($user->hasRole('company') && $application->offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can review all applications
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can accept the application.
     */
    public function accept(User $user, Application $application): bool
    {
        return $this->review($user, $application) && $application->status === 'pending';
    }

    /**
     * Determine whether the user can reject the application.
     */
    public function reject(User $user, Application $application): bool
    {
        return $this->review($user, $application) && $application->status === 'pending';
    }

    /**
     * Determine whether the user can assign supervisor to application.
     */
    public function assignSupervisor(User $user, Application $application): bool
    {
        return $user->hasRole('admin') && $application->status === 'accepted';
    }

    /**
     * Determine whether the user can create stage from application.
     */
    public function createStage(User $user, Application $application): bool
    {
        return $this->review($user, $application) && $application->status === 'accepted' && !$application->stage;
    }

    /**
     * Determine whether the user can view application documents.
     */
    public function viewDocuments(User $user, Application $application): bool
    {
        return $this->view($user, $application);
    }

    /**
     * Determine whether the user can upload documents to application.
     */
    public function uploadDocuments(User $user, Application $application): bool
    {
        // Student can upload to their own applications
        return $user->hasRole('student') && $application->student_id === $user->id;
    }

    /**
     * Determine whether the user can review documents in application.
     */
    public function reviewDocuments(User $user, Application $application): bool
    {
        return $this->review($user, $application);
    }
}
