<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create an in-app notification for a user.
     */
    public function createNotification(
        User $user,
        string $title,
        string $message,
        string $type = 'general',
        ?Model $relatedModel = null,
        string $priority = 'medium',
        ?string $actionUrl = null,
        ?string $actionText = null
    ): Notification {
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'priority' => $priority,
            'action_url' => $actionUrl,
            'action_text' => $actionText,
            'notifiable_type' => $relatedModel ? get_class($relatedModel) : null,
            'notifiable_id' => $relatedModel ? $relatedModel->getKey() : null,
            'is_read' => false,
        ]);

        // Optionally send email if user has email notifications enabled
        if ($this->shouldSendEmail($user, $type)) {
            $this->sendEmailNotification($user, $notification);
        }

        return $notification;
    }

    /**
     * Create notifications for multiple users.
     */
    public function createBulkNotifications(
        array $users,
        string $title,
        string $message,
        string $type = 'general',
        ?Model $relatedModel = null,
        string $priority = 'medium'
    ): array {
        $notifications = [];

        foreach ($users as $user) {
            $notifications[] = $this->createNotification(
                $user,
                $title,
                $message,
                $type,
                $relatedModel,
                $priority
            );
        }

        return $notifications;
    }

    /**
     * Send email notification.
     */
    public function sendEmailNotification(User $user, Notification $notification): bool
    {
        try {
            // Use Laravel's built-in notification system or custom mail
            // For now, we'll log it
            Log::info("Email notification would be sent to {$user->email}: {$notification->title}");

            $notification->update([
                'sent_via_email' => true,
                'email_sent_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send email notification: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification): bool
    {
        return $notification->markAsRead();
    }

    /**
     * Mark multiple notifications as read.
     */
    public function markBulkAsRead(array $notificationIds, User $user): int
    {
        return Notification::whereIn('id', $notificationIds)
            ->where('user_id', $user->id)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get unread notifications count for user.
     */
    public function getUnreadCount(User $user): int
    {
        return $user->notifications()->unread()->count();
    }

    /**
     * Clean up old notifications.
     */
    public function cleanupOldNotifications(int $daysOld = 90): int
    {
        return Notification::where('created_at', '<', now()->subDays($daysOld))
            ->where('is_read', true)
            ->delete();
    }

    /**
     * Send reminder notifications.
     */
    public function sendReminders(): array
    {
        $reminders = [];

        // Reminder for pending applications (after 7 days)
        $oldPendingApplications = \App\Models\Application::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->with('student')
            ->get();

        foreach ($oldPendingApplications as $application) {
            $reminders[] = $this->createNotification(
                $application->student,
                'Application Pending Review',
                "Your application for '{$application->offer->title}' is still pending review. Please follow up if needed.",
                'application_reminder',
                $application,
                'low'
            );
        }

        // Reminder for upcoming stage deadlines (7 days)
        $upcomingDeadlines = \App\Models\Stage::where('status', 'active')
            ->where('end_date', '>', now())
            ->where('end_date', '<=', now()->addDays(7))
            ->with(['student', 'offer.company'])
            ->get();

        foreach ($upcomingDeadlines as $stage) {
            $daysLeft = now()->diffInDays($stage->end_date);
            $reminders[] = $this->createNotification(
                $stage->student,
                'Internship Deadline Approaching',
                "Your internship at {$stage->offer->company->company_name} ends in {$daysLeft} days.",
                'deadline_reminder',
                $stage,
                'high'
            );
        }

        return $reminders;
    }

    /**
     * Check if user should receive email notifications for this type.
     */
    private function shouldSendEmail(User $user, string $type): bool
    {
        // This could be based on user preferences stored in database
        // For now, send emails for high priority notifications
        $emailTypes = ['application_status', 'stage_assignment', 'deadline_reminder'];

        return in_array($type, $emailTypes);
    }

    // Legacy methods for backward compatibility
    public function sendApplicationStatusEmail(User $user, $application, string $newStatus)
    {
        return $this->createNotification(
            $user,
            'Application Status Updated',
            "Your application status has been updated to: {$newStatus}",
            'application_status',
            $application
        );
    }

    public function sendStageProgressEmail(User $user, $stage, string $progress)
    {
        return $this->createNotification(
            $user,
            'Stage Progress Updated',
            "Stage progress updated: {$progress}",
            'stage_progress',
            $stage
        );
    }
}