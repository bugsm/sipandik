<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Riwayat Status Laporan (Polymorphic untuk tracking perubahan status)
     */
    public function up(): void
    {
        Schema::create('report_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Polymorphic relation
            $table->uuid('reportable_id');
            $table->string('reportable_type'); // App\Models\BugReport atau App\Models\DataRequest
            
            // Status change
            $table->string('status_lama', 50)->nullable();
            $table->string('status_baru', 50);
            
            // Action info
            $table->string('aksi'); // diajukan, diverifikasi, diproses, ditolak, selesai, dll
            $table->text('keterangan')->nullable();
            
            // Who made the change
            $table->uuid('user_id'); // Admin/User yang melakukan aksi
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            // Indexes
            $table->index(['reportable_id', 'reportable_type']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_histories');
    }
};
