<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Opd;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Contoh aplikasi yang dikelola OPD
     */
    public function run(): void
    {
        // Get Diskominfo OPD
        $diskominfo = Opd::where('kode', 'DISKOMINFO')->first();
        $bappeda = Opd::where('kode', 'BAPPEDA')->first();
        $dinkes = Opd::where('kode', 'DINKES')->first();
        $bps = Opd::where('kode', 'BPS')->first();
        $dpmptsp = Opd::where('kode', 'DPMPTSP')->first();

        $applications = [
            // Diskominfo Apps
            [
                'opd_id' => $diskominfo?->id,
                'nama' => 'Portal Lampung',
                'versi' => '2.0.0',
                'url' => 'https://lampungprov.go.id',
                'deskripsi' => 'Portal resmi Pemerintah Provinsi Lampung',
                'platform' => 'web',
                'pic_nama' => 'Admin Diskominfo',
                'pic_telepon' => '08123456789',
                'pic_email' => 'admin@lampungprov.go.id',
                'is_active' => true,
            ],
            [
                'opd_id' => $diskominfo?->id,
                'nama' => 'SIPANDIK',
                'versi' => '1.0.0',
                'url' => 'https://sipandik.lampungprov.go.id',
                'deskripsi' => 'Sistem Pelaporan Instansi Sandi dan Statistik',
                'platform' => 'web',
                'pic_nama' => 'Tim Sandi & Statistik',
                'pic_telepon' => '08123456790',
                'pic_email' => 'sandi@diskominfo.lampungprov.go.id',
                'is_active' => true,
            ],
            [
                'opd_id' => $diskominfo?->id,
                'nama' => 'E-Office Lampung',
                'versi' => '3.1.0',
                'url' => 'https://eoffice.lampungprov.go.id',
                'deskripsi' => 'Sistem Perkantoran Elektronik',
                'platform' => 'web',
                'pic_nama' => 'Admin E-Office',
                'pic_telepon' => '08123456791',
                'pic_email' => 'eoffice@lampungprov.go.id',
                'is_active' => true,
            ],
            [
                'opd_id' => $diskominfo?->id,
                'nama' => 'Lampung Dalam Angka API',
                'versi' => '1.0.0',
                'url' => 'https://api.opendata.lampungprov.go.id',
                'deskripsi' => 'API untuk akses data statistik Lampung',
                'platform' => 'api',
                'pic_nama' => 'Tim Data Statistik',
                'pic_telepon' => '08123456792',
                'pic_email' => 'opendata@lampungprov.go.id',
                'is_active' => true,
            ],

            // Bappeda Apps
            [
                'opd_id' => $bappeda?->id,
                'nama' => 'SIPD (Sistem Informasi Perencanaan Daerah)',
                'versi' => '2.0.0',
                'url' => 'https://sipd.lampungprov.go.id',
                'deskripsi' => 'Sistem perencanaan pembangunan daerah',
                'platform' => 'web',
                'pic_nama' => 'Admin Bappeda',
                'pic_telepon' => '08123456793',
                'pic_email' => 'sipd@bappeda.lampungprov.go.id',
                'is_active' => true,
            ],

            // Dinkes Apps
            [
                'opd_id' => $dinkes?->id,
                'nama' => 'SIMPUS (Sistem Informasi Puskesmas)',
                'versi' => '4.0.0',
                'url' => 'https://simpus.dinkes.lampungprov.go.id',
                'deskripsi' => 'Sistem informasi pelayanan puskesmas',
                'platform' => 'web',
                'pic_nama' => 'Admin Dinkes',
                'pic_telepon' => '08123456794',
                'pic_email' => 'simpus@dinkes.lampungprov.go.id',
                'is_active' => true,
            ],

            // BPS Apps
            [
                'opd_id' => $bps?->id,
                'nama' => 'Dashboard Statistik Lampung',
                'versi' => '1.5.0',
                'url' => 'https://dashboard.lampung.bps.go.id',
                'deskripsi' => 'Dashboard visualisasi data statistik',
                'platform' => 'web',
                'pic_nama' => 'Admin BPS',
                'pic_telepon' => '08123456795',
                'pic_email' => 'admin@lampung.bps.go.id',
                'is_active' => true,
            ],

            // DPMPTSP Apps
            [
                'opd_id' => $dpmptsp?->id,
                'nama' => 'OSS (Online Single Submission) Lampung',
                'versi' => '2.0.0',
                'url' => 'https://oss.lampungprov.go.id',
                'deskripsi' => 'Sistem perizinan berusaha terintegrasi',
                'platform' => 'web',
                'pic_nama' => 'Admin DPMPTSP',
                'pic_telepon' => '08123456796',
                'pic_email' => 'oss@dpmptsp.lampungprov.go.id',
                'is_active' => true,
            ],
        ];

        foreach ($applications as $app) {
            if ($app['opd_id']) {
                Application::create($app);
            }
        }
    }
}
