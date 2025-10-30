<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'matricule',
        'department',
        'level',
        'specialization',
        'phone',
        'address',
        'emergency_contact',
        'cv_path',
        'transcript_path',
    ];

    protected $casts = [
        'cv_path' => 'encrypted',
        'transcript_path' => 'encrypted',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'student_id');
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class, 'student_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'student_id');
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

    // Scopes
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }
}
