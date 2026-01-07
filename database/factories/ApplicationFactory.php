<?php

namespace Database\Factories;

use App\Models\Opd;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'opd_id' => Opd::factory(),
            'nama' => fake()->unique()->word() . ' App',
            'deskripsi' => fake()->sentence(),
            'url' => fake()->url(),
            'platform' => fake()->randomElement(['website', 'mobile', 'desktop']),
            'is_active' => true,
        ];
    }
}
