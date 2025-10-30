<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any offers.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('student') || $user->hasRole('company') || $user->hasRole('supervisor') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the offer.
     */
    public function view(User $user, Offer $offer): bool
    {
        // All authenticated users can view active offers
        if ($offer->status === 'active') {
            return true;
        }

        // Company can view their own offers
        if ($user->hasRole('company') && $offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can view all offers
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create offers.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('company') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the offer.
     */
    public function update(User $user, Offer $offer): bool
    {
        // Company can update their own offers
        if ($user->hasRole('company') && $offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can update all offers
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the offer.
     */
    public function delete(User $user, Offer $offer): bool
    {
        // Company can delete their own offers (with restrictions)
        if ($user->hasRole('company') && $offer->company_id === $user->company->id) {
            // Cannot delete if there are accepted applications or active stages
            return !$offer->applications()->where('status', 'accepted')->exists() &&
                   !$offer->stages()->active()->exists();
        }

        // Admin can delete any offer
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can review applications for the offer.
     */
    public function reviewApplications(User $user, Offer $offer): bool
    {
        // Company can review applications for their own offers
        if ($user->hasRole('company') && $offer->company_id === $user->company->id) {
            return true;
        }

        // Admin can review all applications
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can apply to the offer.
     */
    public function apply(User $user, Offer $offer): bool
    {
        // Only students can apply
        if (!$user->hasRole('student')) {
            return false;
        }

        // Cannot apply if already applied and accepted
        $existingApplication = $offer->applications()
            ->where('student_id', $user->id)
            ->where('status', 'accepted')
            ->exists();

        return !$existingApplication && $offer->canAcceptApplications();
    }

    /**
     * Determine whether the user can approve/reject offers (admin only).
     */
    public function approve(User $user, Offer $offer): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view offer statistics.
     */
    public function viewStatistics(User $user, Offer $offer): bool
    {
        return $user->hasRole('company') && $offer->company_id === $user->company->id ||
               $user->hasRole('admin');
    }
}
