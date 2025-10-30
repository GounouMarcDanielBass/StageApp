<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'application_id',
        'supervisor_id',
        'offer_id',
        'start_date',
        'end_date',
        'status',
        'progress_percentage',
        'objectives',
        'weekly_hours',
        'compensation',
        'location',
        'supervisor_notes',
        'student_notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'objectives' => 'array',
        'progress_percentage' => 'integer',
        'weekly_hours' => 'integer',
        'compensation' => 'decimal:2',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'stage_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'stage_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'stage_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('status', 'active');
    }

    // Accessors
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->end_date && $this->end_date->isPast() && $this->status !== 'completed';
    }

    public function getDurationInDaysAttribute(): ?int
    {
        return $this->start_date && $this->end_date
            ? $this->start_date->diffInDays($this->end_date)
            : null;
    }

    public function getDaysRemainingAttribute(): ?int
    {
        return $this->end_date ? now()->diffInDays($this->end_date, false) : null;
    }

    public function getProgressPercentageAttribute(): int
    {
        return $this->attributes['progress_percentage'] ?? 0;
    }

    // Methods
    public function complete(): bool
    {
        return $this->update([
            'status' => 'completed',
            'progress_percentage' => 100,
        ]);
    }

    public function extendEndDate(Carbon $newEndDate): bool
    {
        return $this->update(['end_date' => $newEndDate]);
    }

    public function updateProgress(int $percentage): bool
    {
        $percentage = max(0, min(100, $percentage));
        return $this->update(['progress_percentage' => $percentage]);
    }

    public function assignSupervisor(User $supervisor): bool
    {
        return $this->update(['supervisor_id' => $supervisor->id]);
    }
}
