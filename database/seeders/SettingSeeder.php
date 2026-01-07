<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'SIPANDIK',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Nama aplikasi',
            ],
            [
                'key' => 'app_full_name',
                'value' => 'Sistem Pelaporan Instansi Sandi dan Statistik',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Nama lengkap aplikasi',
            ],
            [
                'key' => 'app_description',
                'value' => 'Website pelaporan bug sistem dan pengambilan data statistik Diskominfo Provinsi Lampung',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Deskripsi aplikasi',
            ],
            [
                'key' => 'organization_name',
                'value' => 'Dinas Komunikasi dan Informatika Provinsi Lampung',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Nama organisasi',
            ],
            [
                'key' => 'organization_address',
                'value' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Alamat organisasi',
            ],
            [
                'key' => 'organization_phone',
                'value' => '(0721) 481923',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Nomor telepon organisasi',
            ],
            [
                'key' => 'organization_email',
                'value' => 'diskominfo@lampungprov.go.id',
                'group' => 'general',
                'type' => 'string',
                'description' => 'Email organisasi',
            ],

            // Email Settings
            [
                'key' => 'email_from_name',
                'value' => 'SIPANDIK Lampung',
                'group' => 'email',
                'type' => 'string',
                'description' => 'Nama pengirim email',
            ],
            [
                'key' => 'email_from_address',
                'value' => 'noreply@sipandik.lampungprov.go.id',
                'group' => 'email',
                'type' => 'string',
                'description' => 'Alamat pengirim email',
            ],
            [
                'key' => 'email_notification_enabled',
                'value' => 'true',
                'group' => 'email',
                'type' => 'boolean',
                'description' => 'Aktifkan notifikasi email',
            ],

            // Notification Settings
            [
                'key' => 'notify_on_new_report',
                'value' => 'true',
                'group' => 'notification',
                'type' => 'boolean',
                'description' => 'Kirim notifikasi ketika ada laporan baru',
            ],
            [
                'key' => 'notify_on_status_change',
                'value' => 'true',
                'group' => 'notification',
                'type' => 'boolean',
                'description' => 'Kirim notifikasi ketika status laporan berubah',
            ],
            [
                'key' => 'notify_admin_emails',
                'value' => '["admin@sipandik.lampungprov.go.id"]',
                'group' => 'notification',
                'type' => 'json',
                'description' => 'Daftar email admin untuk notifikasi',
            ],

            // File Upload Settings
            [
                'key' => 'max_file_size',
                'value' => '10485760',
                'group' => 'upload',
                'type' => 'integer',
                'description' => 'Ukuran maksimum file upload dalam bytes (default: 10MB)',
            ],
            [
                'key' => 'allowed_file_types',
                'value' => '["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "xls", "xlsx", "csv", "txt", "zip"]',
                'group' => 'upload',
                'type' => 'json',
                'description' => 'Tipe file yang diizinkan untuk upload',
            ],
            [
                'key' => 'max_attachments',
                'value' => '5',
                'group' => 'upload',
                'type' => 'integer',
                'description' => 'Jumlah maksimum lampiran per laporan',
            ],

            // Data Request Settings
            [
                'key' => 'data_download_expiry_days',
                'value' => '7',
                'group' => 'data_request',
                'type' => 'integer',
                'description' => 'Masa berlaku link download data dalam hari',
            ],
            [
                'key' => 'max_download_attempts',
                'value' => '5',
                'group' => 'data_request',
                'type' => 'integer',
                'description' => 'Jumlah maksimum download per permintaan data',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
