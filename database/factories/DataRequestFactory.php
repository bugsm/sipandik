<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Opd;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'opd_id' => Opd::factory(),
            'nama_data' => fake()->words(3, true),
            'tujuan_penggunaan' => fake()->sentence(),
            'format_data' => ['excel', 'pdf'],
            'status' => 'diajukan',
        ];
    }
}
