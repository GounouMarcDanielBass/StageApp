<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'is_read',
        'read_at',
        'message_type', // 'text', 'file', 'system'
        'attachment_path',
        'attachment_name',
        'attachment_size',
        'conversation_id', // For grouping messages in threads
        'parent_id', // For replies
        'stage_id', // Link to internship if relevant
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'attachment_size' => 'integer',
    ];

    // Relationships
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Message::class, 'conversation_id');
    }

    public function conversationMessages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
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

    public function scopeByConversation($query, $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where(function ($subQ) use ($userId1, $userId2) {
                $subQ->where('sender_id', $userId1)->where('receiver_id', $userId2);
            })->orWhere(function ($subQ) use ($userId1, $userId2) {
                $subQ->where('sender_id', $userId2)->where('receiver_id', $userId1);
            });
        });
    }

    // Accessors
    public function getIsUnreadAttribute(): bool
    {
        return !$this->is_read;
    }

    public function getHasAttachmentAttribute(): bool
    {
        return !empty($this->attachment_path);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path ? \Illuminate\Support\Facades\Storage::url($this->attachment_path) : null;
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

    public function reply(int $senderId, string $content): Message
    {
        return self::create([
            'sender_id' => $senderId,
            'receiver_id' => $this->sender_id === $senderId ? $this->receiver_id : $this->sender_id,
            'content' => $content,
            'conversation_id' => $this->conversation_id ?? $this->id,
            'parent_id' => $this->id,
            'stage_id' => $this->stage_id,
        ]);
    }
}
