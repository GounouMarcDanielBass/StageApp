<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusChanged;
use App\Mail\StageProgressUpdated;

class NotificationService
{
    /**
     * Create an in-app notification for a user.
     */
    public function createNotification(User $user, string $type, string $message, $relatedModel = null)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'message' => $message,
            'related_id' => $relatedModel ? $relatedModel->id : null,
            'related_type' => $relatedModel ? get_class($relatedModel) : null,
        ]);
    }

    /**
     * Send email notification for application status change.
     */
    public function sendApplicationStatusEmail(User $user, $application, string $newStatus)
    {
        Mail::to($user->email)->send(new ApplicationStatusChanged($application, $newStatus));
        $this->createNotification($user, 'application_status', "Your application status has been updated to: {$newStatus}", $application);
    }

    /**
     * Send email notification for stage progress.
     */
    public function sendStageProgressEmail(User $user, $stage, string $progress)
    {
        Mail::to($user->email)->send(new StageProgressUpdated($stage, $progress));
        $this->createNotification($user, 'stage_progress', "Stage progress updated: {$progress}", $stage);
    }
}