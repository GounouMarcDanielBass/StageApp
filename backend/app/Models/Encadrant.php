<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encadrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department',
        'speciality'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}