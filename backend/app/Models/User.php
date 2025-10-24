<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Facades\Log;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function encadrant()
    {
        return $this->hasOne(Encadrant::class);
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

        
    public function isEtudiant()
    {
        return $this->role && $this->role->name === 'etudiant';
    }

    public function isEntreprise()
    {
        return $this->role && $this->role->name === 'entreprise';
    }

    public function isEncadrant()
    {
        return $this->role && $this->role->name === 'encadrant';
    }

    public function hasRole($role)
    {
        return $this->role && $this->role->name === $role;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'student_id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'user_id');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function offers()
    {
        return $this->hasManyThrough(Offer::class, Entreprise::class, 'user_id', 'entreprise_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
