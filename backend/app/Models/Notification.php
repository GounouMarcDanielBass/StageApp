<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // 'application_status', 'stage_update', 'evaluation', 'document_review', etc.
        'title',
        'message',
        'is_read',
        'read_at',
        'priority', // 'low', 'medium', 'high', 'urgent'
        'action_url',
        'action_text',
        'expires_at',
        'notifiable_type',
        'notifiable_id',
        'data', // JSON data for additional context
        'sent_via_email',
        'email_sent_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'data' => 'array',
        'sent_via_email' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsUrgentAttribute(): bool
    {
        return $this->priority === 'urgent';
    }

    public function getIsHighPriorityAttribute(): bool
    {
        return in_array($this->priority, ['high', 'urgent']);
    }

    // Methods
    public function markAsRead(): bool
    {
        if (!$this->is_read) {
            return $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
        return true;
    }

    public function markAsUnread(): bool
    {
        return $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function sendEmail(): bool
    {
        // TODO: Implement email sending logic
        return $this->update([
            'sent_via_email' => true,
            'email_sent_at' => now(),
        ]);
    }
}
