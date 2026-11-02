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
        Schema::table('bansos', function (Blueprint $table) {
            $table->enum('status', ['pending', 'diusulkan', 'disetujui', 'ditolak'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bansos', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])
                ->default('pending')
                ->change();
        });
    }
};
