<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // pengajuan_disetujui, bansos_ditolak, informasi_baru, etc.
            $table->string('title');
            $table->text('message');
            $table->string('related_model')->nullable(); // Pengajuan, Bansos, Informasi
            $table->unsignedBigInteger('related_id')->nullable(); // ID dari model terkait
            $table->json('data')->nullable(); // Data tambahan dalam JSON format
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index('user_id');
            $table->index('type');
            $table->index('read_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
