<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
