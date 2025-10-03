<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'offre_id',
        'user_id',
    ];

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
