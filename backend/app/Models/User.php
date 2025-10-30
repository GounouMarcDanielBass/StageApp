<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
        'google2fa_secret',
        'google2fa_enabled',
        'failed_attempts',
        'locked_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'google2fa_enabled' => 'boolean',
        'failed_attempts' => 'integer',
        'locked_until' => 'datetime',
    ];

    // Relationships
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function supervisor(): HasOne
    {
        return $this->hasOne(Supervisor::class);
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

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'company_id');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    // Scopes
    public function scopeByRole($query, string $roleName)
    {
        return $query->whereHas('role', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('locked_until', '<=', now())->orWhereNull('locked_until');
    }

    // Accessors & Mutators
    public function getIsLockedAttribute(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function getRoleNameAttribute(): ?string
    {
        return $this->role?->name;
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->role_name === 'admin';
    }

    public function getIsStudentAttribute(): bool
    {
        return $this->role_name === 'student';
    }

    public function getIsCompanyAttribute(): bool
    {
        return $this->role_name === 'company';
    }

    public function getIsSupervisorAttribute(): bool
    {
        return $this->role_name === 'supervisor';
    }

    // Methods
    public function hasRole(string $role): bool
    {
        return $this->role_name === $role;
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->is_admin;
    }

    public function incrementFailedAttempts(): void
    {
        $this->increment('failed_attempts');
        if ($this->failed_attempts >= 5) {
            $this->locked_until = now()->addMinutes(30);
            $this->save();
        }
    }

    public function resetFailedAttempts(): void
    {
        $this->update(['failed_attempts' => 0, 'locked_until' => null]);
    }

    public function isAccountLocked(): bool
    {
        return $this->is_locked;
    }

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role' => $this->role_name,
            'is_locked' => $this->is_locked,
        ];
    }
}
