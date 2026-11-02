<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jenis_kelamin', 20)->nullable()->after('nik');
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('agama', 30)->nullable()->after('tanggal_lahir');
            $table->string('pendidikan')->nullable()->after('agama');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
            $table->text('alamat')->nullable()->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'pendidikan',
                'pekerjaan',
                'alamat',
            ]);
        });
    }
};