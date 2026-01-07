<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Notifikasi Email untuk tracking pengiriman notifikasi
     */
    public function up(): void
    {
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Penerima notifikasi
            
            // Polymorphic relation ke laporan terkait
            $table->uuid('notifiable_id')->nullable();
            $table->string('notifiable_type')->nullable();
            
            // Email details
            $table->string('jenis')->nullable(); // bug_report_submitted, etc.
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('email_to');
            
            // Status pengiriman
            $table->enum('status', [
                'pending',
                'sent',
                'failed',
                'read'
            ])->default('pending');
            
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index('user_id');
            $table->index(['notifiable_id', 'notifiable_type']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_notifications');
    }
};
