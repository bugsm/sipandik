<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Daftar Aplikasi yang dapat dilaporkan
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('opd_id'); // OPD Pengelola Aplikasi
            $table->string('nama'); // Nama Aplikasi
            $table->string('versi', 50)->nullable(); // Versi aplikasi
            $table->string('url')->nullable(); // URL Aplikasi
            $table->text('deskripsi')->nullable();
            $table->enum('platform', ['website', 'mobile', 'desktop', 'api', 'lainnya'])->default('website');
            $table->string('pic_nama')->nullable(); // Person In Charge
            $table->string('pic_telepon', 20)->nullable();
            $table->string('pic_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('opd_id')->references('id')->on('opd')->onDelete('restrict');
            $table->index('opd_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
