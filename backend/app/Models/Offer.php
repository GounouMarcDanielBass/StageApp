<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Offer extends Model
{
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'requirements',
        'location',
        'duration_months',
        'compensation',
        'benefits',
        'application_deadline',
        'status',
        'required_skills',
        'department',
        'is_remote',
        'max_applications',
    ];

    protected $casts = [
        'application_deadline' => 'datetime',
        'required_skills' => 'array',
        'compensation' => 'decimal:2',
        'is_remote' => 'boolean',
        'max_applications' => 'integer',
        'duration_months' => 'integer',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'offer_id');
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
                    ->where('application_deadline', '>', now());
    }

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeByDepartment(Builder $query, string $department): Builder
    {
        return $query->where('department', $department);
    }

    public function scopeRemote(Builder $query): Builder
    {
        return $query->where('is_remote', true);
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->application_deadline && $this->application_deadline->isPast();
    }

    public function getApplicationCountAttribute(): int
    {
        return $this->applications()->count();
    }

    public function getHasReachedMaxApplicationsAttribute(): bool
    {
        return $this->max_applications && $this->application_count >= $this->max_applications;
    }

    public function getDaysUntilDeadlineAttribute(): ?int
    {
        return $this->application_deadline ? now()->diffInDays($this->application_deadline, false) : null;
    }

    // Methods
    public function canAcceptApplications(): bool
    {
        return $this->status === 'active' &&
               !$this->is_expired &&
               !$this->has_reached_max_applications;
    }

    public function getAcceptedApplications()
    {
        return $this->applications()->where('status', 'accepted');
    }
}
