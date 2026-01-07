<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Application;
use App\Models\VulnerabilityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class BugReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'application_id' => Application::factory(),
            'vulnerability_type_id' => VulnerabilityType::factory(),
            'judul' => fake()->sentence(),
            'deskripsi' => fake()->paragraph(),
            'langkah_reproduksi' => fake()->paragraph(),
            'dampak' => fake()->paragraph(),
            'tanggal_kejadian' => fake()->date(),
            'status' => 'diajukan',
            'status_apresiasi' => 'belum_dinilai',
        ];
    }
}
