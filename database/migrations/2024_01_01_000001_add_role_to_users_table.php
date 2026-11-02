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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'masyarakat', 'kepala_desa'])->default('masyarakat')->after('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->string('nik')->nullable()->unique()->after('status'); // NIK untuk masyarakat
            $table->string('username')->nullable()->unique()->after('nik'); // Username untuk admin dan kepala desa
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('status');
            $table->dropColumn('nik');
            $table->dropColumn('username');
            $table->dropSoftDeletes();
        });
    }
};
