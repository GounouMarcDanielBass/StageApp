<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Etudiant;
use App\Models\Offre;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'mime_type',
        'size',
        'status',
        'student_id',
        'offer_id',
    ];

    protected $casts = [
        'path' => 'encrypted',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }
}
