<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'source' => $this->faker->word,
            'owner' => User::all()->random()->id, // Selecciona un ID de usuario aleatorio existente
            'created_by' => User::all()->random()->id, // Selecciona un ID de usuario aleatorio existente
        ];
    }
}
