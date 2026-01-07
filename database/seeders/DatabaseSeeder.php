<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Urutan seeder penting karena ada dependency antar tabel:
     * 1. Users - untuk admin dan user pelapor
     * 2. OPD - organisasi perangkat daerah
     * 3. VulnerabilityType - jenis kerentanan
     * 4. Applications - yang depend ke OPD
     * 5. Settings - konfigurasi sistem
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OpdSeeder::class,
            VulnerabilityTypeSeeder::class,
            ApplicationSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
