<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * OPD = Organisasi Perangkat Daerah (Government Departments)
     */
    public function up(): void
    {
        Schema::create('opd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 20)->unique(); // Kode OPD
            $table->string('nama'); // Nama OPD
            $table->string('singkatan', 50)->nullable(); // Singkatan
            $table->string('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd');
    }
};
