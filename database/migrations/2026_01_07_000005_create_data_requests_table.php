<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Permintaan Open Data / Data Requests
     */
    public function up(): void
    {
        Schema::create('data_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ticket_number', 30)->unique(); // Nomor tiket unik
            $table->uuid('user_id'); // Pemohon data
            $table->uuid('opd_id')->nullable(); // OPD sumber data (jika spesifik)
            
            // Data permintaan
            $table->string('nama_data'); // Nama data yang diminta
            $table->string('sumber_data')->nullable(); // Sumber data
            $table->string('tahun_periode', 50)->nullable(); // Tahun/periode data
            $table->text('tujuan_penggunaan'); // Tujuan penggunaan data
            $table->text('deskripsi')->nullable(); // Deskripsi tambahan
            
            // Format yang diinginkan
            $table->json('format_data')->nullable(); // ['excel', 'csv', 'pdf', 'json']
            
            // Status
            $table->enum('status', [
                'diajukan',      // Baru diajukan
                'diverifikasi',  // Sudah diverifikasi admin
                'diproses',      // Sedang disiapkan
                'tersedia',      // Data sudah tersedia untuk diunduh
                'ditolak',       // Permintaan ditolak
                'selesai'        // Sudah diunduh/selesai
            ])->default('diajukan');
            
            // Admin handling
            $table->uuid('handled_by')->nullable();
            $table->timestamp('handled_at')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->text('alasan_penolakan')->nullable();
            
            // Data response
            $table->string('file_path')->nullable(); // Path file data yang disediakan
            $table->string('file_name')->nullable();
            $table->bigInteger('file_size')->nullable(); // Ukuran file dalam bytes
            $table->timestamp('downloaded_at')->nullable(); // Waktu diunduh
            $table->integer('download_count')->default(0);
            
            // Batas waktu
            $table->date('tanggal_dibutuhkan')->nullable();
            $table->timestamp('expired_at')->nullable(); // Masa berlaku link download
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('opd_id')->references('id')->on('opd')->onDelete('set null');
            $table->foreign('handled_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('user_id');
            $table->index('opd_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_requests');
    }
};
