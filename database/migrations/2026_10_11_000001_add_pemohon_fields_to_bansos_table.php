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
            $table->string('nama_lengkap')->nullable()->after('user_id');
            $table->string('nik', 20)->nullable()->after('nama_lengkap');
            $table->text('alamat')->nullable()->after('nik');
            $table->string('rt_rw', 20)->nullable()->after('alamat');
            $table->string('no_hp', 20)->nullable()->after('rt_rw');
            $table->string('status_tempat_tinggal', 50)->nullable()->after('no_hp');
            $table->string('desa')->nullable()->after('status_tempat_tinggal');
            $table->text('kondisi_ekonomi')->nullable()->after('desa');
            $table->string('dokumen_ktp')->nullable()->after('dokumen_pendukung');
            $table->string('dokumen_kk')->nullable()->after('dokumen_ktp');
            $table->string('dokumen_rumah')->nullable()->after('dokumen_kk');
        });

        Schema::table('bansos', function (Blueprint $table) {
            $table->text('alasan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bansos', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap',
                'nik',
                'alamat',
                'rt_rw',
                'no_hp',
                'status_tempat_tinggal',
                'desa',
                'kondisi_ekonomi',
                'dokumen_ktp',
                'dokumen_kk',
                'dokumen_rumah',
            ]);
        });

        Schema::table('bansos', function (Blueprint $table) {
            $table->text('alasan')->nullable(false)->change();
        });
    }
};
