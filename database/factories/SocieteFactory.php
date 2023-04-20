<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Societe>
 */
class SocieteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'raison_sociale' => fake()->unique()->company(),
            'ice' => fake()->unique()->randomNumber(5, true),
            'telephone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'adresse' => fake()->address(),
            'ville' => fake()->city()
        ];
    }
}
