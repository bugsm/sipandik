<?php

namespace Database\Seeders;

use App\Models\Opd;
use Illuminate\Database\Seeder;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data OPD Provinsi Lampung
     */
    public function run(): void
    {
        $opdList = [
            [
                'kode' => 'DISKOMINFO',
                'nama' => 'Dinas Komunikasi dan Informatika Provinsi Lampung',
                'singkatan' => 'Diskominfo',
                'alamat' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'telepon' => '(0721) 481923',
                'email' => 'diskominfo@lampungprov.go.id',
                'website' => 'https://diskominfo.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan komunikasi dan informatika di Provinsi Lampung',
                'is_active' => true,
            ],
            [
                'kode' => 'BAPPEDA',
                'nama' => 'Badan Perencanaan Pembangunan Daerah Provinsi Lampung',
                'singkatan' => 'Bappeda',
                'alamat' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'telepon' => '(0721) 481456',
                'email' => 'bappeda@lampungprov.go.id',
                'website' => 'https://bappeda.lampungprov.go.id',
                'deskripsi' => 'Badan yang menangani perencanaan pembangunan daerah',
                'is_active' => true,
            ],
            [
                'kode' => 'DINKES',
                'nama' => 'Dinas Kesehatan Provinsi Lampung',
                'singkatan' => 'Dinkes',
                'alamat' => 'Jl. Dr. Warsito No.5, Bandar Lampung',
                'telepon' => '(0721) 703837',
                'email' => 'dinkes@lampungprov.go.id',
                'website' => 'https://dinkes.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan kesehatan',
                'is_active' => true,
            ],
            [
                'kode' => 'DISDIK',
                'nama' => 'Dinas Pendidikan dan Kebudayaan Provinsi Lampung',
                'singkatan' => 'Disdikbud',
                'alamat' => 'Jl. Gatot Subroto No.1, Bandar Lampung',
                'telepon' => '(0721) 481200',
                'email' => 'disdik@lampungprov.go.id',
                'website' => 'https://disdik.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan pendidikan dan kebudayaan',
                'is_active' => true,
            ],
            [
                'kode' => 'DISPARBUD',
                'nama' => 'Dinas Pariwisata dan Ekonomi Kreatif Provinsi Lampung',
                'singkatan' => 'Disparekraf',
                'alamat' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'telepon' => '(0721) 481634',
                'email' => 'disparekraf@lampungprov.go.id',
                'website' => 'https://disparekraf.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan pariwisata dan ekonomi kreatif',
                'is_active' => true,
            ],
            [
                'kode' => 'DPMPTSP',
                'nama' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Lampung',
                'singkatan' => 'DPMPTSP',
                'alamat' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'telepon' => '(0721) 481789',
                'email' => 'dpmptsp@lampungprov.go.id',
                'website' => 'https://dpmptsp.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan penanaman modal dan perizinan',
                'is_active' => true,
            ],
            [
                'kode' => 'BPS',
                'nama' => 'Badan Pusat Statistik Provinsi Lampung',
                'singkatan' => 'BPS',
                'alamat' => 'Jl. Basuki Rahmat No.54, Bandar Lampung',
                'telepon' => '(0721) 482909',
                'email' => 'bps1800@bps.go.id',
                'website' => 'https://lampung.bps.go.id',
                'deskripsi' => 'Badan yang menangani urusan statistik',
                'is_active' => true,
            ],
            [
                'kode' => 'DISHUB',
                'nama' => 'Dinas Perhubungan Provinsi Lampung',
                'singkatan' => 'Dishub',
                'alamat' => 'Jl. Kapten A. Rivai, Bandar Lampung',
                'telepon' => '(0721) 481567',
                'email' => 'dishub@lampungprov.go.id',
                'website' => 'https://dishub.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan perhubungan dan transportasi',
                'is_active' => true,
            ],
            [
                'kode' => 'DISNAKER',
                'nama' => 'Dinas Tenaga Kerja dan Transmigrasi Provinsi Lampung',
                'singkatan' => 'Disnakertrans',
                'alamat' => 'Jl. Gatot Subroto No.44, Bandar Lampung',
                'telepon' => '(0721) 481234',
                'email' => 'disnaker@lampungprov.go.id',
                'website' => 'https://disnakertrans.lampungprov.go.id',
                'deskripsi' => 'Dinas yang menangani urusan tenaga kerja dan transmigrasi',
                'is_active' => true,
            ],
            [
                'kode' => 'INSPEKTORAT',
                'nama' => 'Inspektorat Provinsi Lampung',
                'singkatan' => 'Inspektorat',
                'alamat' => 'Jl. Wolter Monginsidi No.69, Bandar Lampung',
                'telepon' => '(0721) 481345',
                'email' => 'inspektorat@lampungprov.go.id',
                'website' => 'https://inspektorat.lampungprov.go.id',
                'deskripsi' => 'Badan pengawas internal pemerintah provinsi',
                'is_active' => true,
            ],
        ];

        foreach ($opdList as $opd) {
            Opd::create($opd);
        }
    }
}
