<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stage_id' => \App\Models\Stage::factory(),
            'user_id' => \App\Models\User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->text(),
        ];
    }
}