<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->text(),
            'requirements' => fake()->text(),
            'type' => fake()->randomElement(['Stage', 'Alternance']),
            'duration' => fake()->numberBetween(1, 12),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'status' => 'active',
            'company_id' => \App\Models\Entreprise::factory(),
            'location' => fake()->city(),
        ];
    }
}