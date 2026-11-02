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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn('jenis_surat');
            $table->foreignId('jenis_surat_id')->after('user_id')->nullable()->constrained('jenis_surats')->onDelete('set null');
        });

        Schema::table('bansos', function (Blueprint $table) {
            $table->dropColumn('jenis_bansos');
            $table->foreignId('jenis_bansos_id')->after('user_id')->nullable()->constrained('jenis_bansos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
            $table->dropColumn('jenis_surat_id');
            $table->string('jenis_surat')->after('user_id');
        });

        Schema::table('bansos', function (Blueprint $table) {
            $table->dropForeign(['jenis_bansos_id']);
            $table->dropColumn('jenis_bansos_id');
            $table->string('jenis_bansos')->after('user_id');
        });
    }
};
