<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisSurat::firstOrCreate(
            ['nama_surat' => 'Surat Keterangan Domisili'],
            ['keterangan' => 'Surat keterangan untuk menerangkan bahwa yang bersangkutan benar-benar tinggal/berdomisili di Desa Kalinaun.']
        );

        JenisSurat::firstOrCreate(
            ['nama_surat' => 'Surat Keterangan Usaha'],
            ['keterangan' => 'Surat keterangan untuk membantu warga memperoleh legalitas atas usaha mikro/kecil yang dijalankan di wilayah desa.']
        );

        JenisSurat::firstOrCreate(
            ['nama_surat' => 'Surat Keterangan Kelakuan Baik'],
            ['keterangan' => 'Surat pengantar untuk kepolisian menerangkan catatan kelakuan baik warga guna keperluan melamar pekerjaan, sekolah, dll.']
        );

        JenisSurat::firstOrCreate(
            ['nama_surat' => 'Surat Keterangan Kurang Mampu'],
            ['keterangan' => 'Surat keterangan terdaftar sebagai keluarga kurang mampu (miskin) untuk keperluan keringanan biaya pendidikan/medis.']
        );
    }
}
