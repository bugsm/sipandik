<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator SIPANDIK',
            'email' => 'admin@sipandik.lampungprov.go.id',
            'phone' => '08123456789',
            'nip' => '199001012020011001',
            'jabatan' => 'Administrator Sistem',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        // Create staff admin users
        User::create([
            'name' => 'Staff Sandi dan Statistik',
            'email' => 'staff.sandi@diskominfo.lampungprov.go.id',
            'phone' => '08123456790',
            'nip' => '199002022020012002',
            'jabatan' => 'Staff Bidang Sandi dan Statistik',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'is_active' => true,
        ]);

        // Create sample users
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@lampungprov.go.id',
                'phone' => '08123456791',
                'nip' => '198503032010011003',
                'jabatan' => 'Kepala Seksi Aplikasi',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@bappeda.lampungprov.go.id',
                'phone' => '08123456792',
                'nip' => '199004042015022004',
                'jabatan' => 'Analis Perencanaan',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@dinkes.lampungprov.go.id',
                'phone' => '08123456793',
                'nip' => '198805052012011005',
                'jabatan' => 'Pranata Komputer',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@dpmptsp.lampungprov.go.id',
                'phone' => '08123456794',
                'nip' => '199106062018022006',
                'jabatan' => 'Staff IT',
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
