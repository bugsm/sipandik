<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Laporan Bug / Bug Reports
     * Kolom Admin: TANGGAL, NAMA PELAPOR, EMAIL PELAPOR, APLIKASI YANG DILAPORKAN, 
     *              PD PENGELOLA APP, JENIS KERENTANAN, STATUS APRESIASI, CEKLIS FOLDER
     */
    public function up(): void
    {
        Schema::create('bug_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ticket_number', 30)->unique(); // Nomor tiket unik
            $table->uuid('user_id'); // Pelapor
            $table->uuid('application_id'); // Aplikasi yang dilaporkan
            $table->uuid('vulnerability_type_id'); // Jenis kerentanan
            
            // Data laporan
            $table->string('judul'); // Judul laporan
            $table->text('deskripsi'); // Deskripsi masalah
            $table->text('langkah_reproduksi')->nullable(); // Steps to reproduce
            $table->text('dampak')->nullable(); // Impact description
            $table->string('url_terkait')->nullable(); // URL terkait bug
            $table->date('tanggal_kejadian'); // Tanggal kejadian
            
            // Status
            $table->enum('status', [
                'diajukan',      // Baru diajukan
                'diverifikasi',  // Sudah diverifikasi admin
                'diproses',      // Sedang ditangani
                'ditolak',       // Laporan ditolak
                'selesai'        // Sudah selesai
            ])->default('diajukan');
            
            // Status Apresiasi
            $table->enum('status_apresiasi', [
                'belum_dinilai',
                'ditolak',
                'diapresiasi',
                'hall_of_fame'
            ])->default('belum_dinilai');
            
            // Ceklis folder / dokumentasi
            $table->boolean('folder_checked')->default(false);
            $table->string('folder_path')->nullable(); // Path folder dokumentasi
            
            // Admin handling
            $table->uuid('handled_by')->nullable(); // Admin yang menangani
            $table->timestamp('handled_at')->nullable();
            $table->text('catatan_admin')->nullable(); // Catatan dari admin
            $table->text('solusi')->nullable(); // Solusi yang diberikan
            
            // Prioritas
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('restrict');
            $table->foreign('vulnerability_type_id')->references('id')->on('vulnerability_types')->onDelete('restrict');
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('user_id');
            $table->index('application_id');
            $table->index('vulnerability_type_id');
            $table->index('status');
            $table->index('status_apresiasi');
            $table->index('tanggal_kejadian');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bug_reports');
    }
};
