<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'offer_id',
        'status',
        'motivation_letter',
        'cv_path',
        'additional_documents',
        'applied_at',
        'reviewed_at',
        'notes',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'additional_documents' => 'array',
        'cv_path' => 'encrypted',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function stage(): HasOne
    {
        return $this->hasOne(Stage::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'application_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsAcceptedAttribute(): bool
    {
        return $this->status === 'accepted';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    public function getCanCreateStageAttribute(): bool
    {
        return $this->is_accepted && !$this->stage;
    }

    // Methods
    public function accept(): bool
    {
        if ($this->update(['status' => 'accepted', 'reviewed_at' => now()])) {
            // TODO: Trigger stage creation workflow
            return true;
        }
        return false;
    }

    public function reject(string $reason = null): bool
    {
        $data = ['status' => 'rejected', 'reviewed_at' => now()];
        if ($reason) {
            $data['notes'] = $reason;
        }
        return $this->update($data);
    }
}
