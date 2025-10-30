<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'evaluator_id',
        'evaluatee_id',
        'evaluation_type', // 'mid_term', 'final', 'monthly'
        'rating',
        'technical_skills',
        'communication_skills',
        'punctuality',
        'teamwork',
        'problem_solving',
        'overall_performance',
        'strengths',
        'areas_for_improvement',
        'recommendations',
        'comments',
        'evaluation_date',
        'is_draft',
    ];

    protected $casts = [
        'evaluation_date' => 'datetime',
        'rating' => 'decimal:1',
        'technical_skills' => 'integer',
        'communication_skills' => 'integer',
        'punctuality' => 'integer',
        'teamwork' => 'integer',
        'problem_solving' => 'integer',
        'overall_performance' => 'integer',
        'strengths' => 'array',
        'areas_for_improvement' => 'array',
        'is_draft' => 'boolean',
    ];

    // Relationships
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    // Scopes
    public function scopeFinal($query)
    {
        return $query->where('evaluation_type', 'final');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('evaluation_type', $type);
    }

    public function scopePublished($query)
    {
        return $query->where('is_draft', false);
    }

    public function scopeDrafts($query)
    {
        return $query->where('is_draft', true);
    }

    // Accessors
    public function getAverageRatingAttribute(): float
    {
        $skills = [
            $this->technical_skills,
            $this->communication_skills,
            $this->punctuality,
            $this->teamwork,
            $this->problem_solving,
        ];

        $validSkills = array_filter($skills, function ($skill) {
            return $skill !== null;
        });

        return $validSkills ? array_sum($validSkills) / count($validSkills) : 0;
    }

    public function getIsExcellentAttribute(): bool
    {
        return $this->overall_performance >= 8;
    }

    public function getIsSatisfactoryAttribute(): bool
    {
        return $this->overall_performance >= 6 && $this->overall_performance < 8;
    }

    public function getNeedsImprovementAttribute(): bool
    {
        return $this->overall_performance < 6;
    }

    // Methods
    public function publish(): bool
    {
        return $this->update(['is_draft' => false, 'evaluation_date' => now()]);
    }

    public function saveAsDraft(): bool
    {
        return $this->update(['is_draft' => true]);
    }
}
