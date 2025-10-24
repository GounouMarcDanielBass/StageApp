<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $table = 'offres';

    protected $fillable = [
        'entreprise_id',
        'title',
        'description',
        'requirements',
        'location',
        'duration',
        'status',
    ];

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
