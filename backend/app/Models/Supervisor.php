<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supervisor extends Model
{
    protected $fillable = [
        'user_id',
        'department',
        'specialization',
        'phone',
        'office_location',
        'max_students',
        'experience_years',
        'bio',
    ];

    protected $casts = [
        'max_students' => 'integer',
        'experience_years' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class, 'supervisor_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'supervisor_id');
    }

    public function currentStudents(): HasMany
    {
        return $this->stages()->where('status', 'active');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? '';
    }

    public function getEmailAttribute(): string
    {
        return $this->user->email ?? '';
    }

    public function getAvailableSlotsAttribute(): int
    {
        $currentCount = $this->currentStudents()->count();
        return max(0, ($this->max_students ?? 5) - $currentCount);
    }

    // Scopes
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    public function scopeAvailable($query)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM stages WHERE supervisor_id = supervisors.id AND status = ?) < max_students', ['active']);
    }
}
