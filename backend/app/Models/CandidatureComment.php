<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidatureComment extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'candidature_id',
        'content'
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Obtenir l'utilisateur qui a créé le commentaire.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir la candidature associée au commentaire.
     */
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
}