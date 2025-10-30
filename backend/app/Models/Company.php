<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'industry',
        'description',
        'website',
        'phone',
        'address',
        'contact_person',
        'contact_email',
        'tax_id',
        'registration_number',
        'logo_path',
    ];

    protected $casts = [
        'logo_path' => 'encrypted',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'company_id');
    }

    public function applications()
    {
        return $this->hasManyThrough(Application::class, Offer::class, 'company_id', 'offer_id');
    }

    public function stages()
    {
        return $this->hasManyThrough(Stage::class, Offer::class, 'company_id', 'offer_id');
    }

    // Accessors
    public function getContactNameAttribute(): string
    {
        return $this->contact_person ?? $this->user->name ?? '';
    }

    public function getEmailAttribute(): string
    {
        return $this->contact_email ?? $this->user->email ?? '';
    }

    // Scopes
    public function scopeByIndustry($query, string $industry)
    {
        return $query->where('industry', $industry);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('registration_number');
    }
}
