<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Lampiran / Attachments (Polymorphic untuk bug_reports dan data_requests)
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Polymorphic relation
            $table->uuid('attachable_id');
            $table->string('attachable_type'); // App\Models\BugReport atau App\Models\DataRequest
            
            // File info
            $table->string('nama_asli'); // Nama file asli
            $table->string('nama_file'); // Nama file yang disimpan
            $table->string('path'); // Path penyimpanan
            $table->string('mime_type', 100);
            $table->bigInteger('ukuran'); // Ukuran dalam bytes
            $table->string('ekstensi', 20);
            
            // Metadata
            $table->enum('tipe', [
                'screenshot',
                'dokumen',
                'log',
                'video',
                'lainnya'
            ])->default('dokumen');
            $table->text('keterangan')->nullable();
            
            // Upload info
            $table->uuid('uploaded_by');
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('restrict');

            // Indexes
            $table->index(['attachable_id', 'attachable_type']);
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
