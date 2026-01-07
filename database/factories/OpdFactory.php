<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OpdFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->company(),
            'kode' => fake()->unique()->bothify('OPD-###'),
            'singkatan' => fake()->word(),
            'alamat' => fake()->address(),
            'telepon' => fake()->phoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'website' => fake()->url(),
            'is_active' => true,
        ];
    }
}
