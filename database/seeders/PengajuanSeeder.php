<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use App\Models\JenisSurat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = User::where('role', 'masyarakat')->first();
        $domisili = JenisSurat::where('nama_surat', 'like', '%Domisili%')->first();
        $usaha = JenisSurat::where('nama_surat', 'like', '%Usaha%')->first();
        $kurangMampu = JenisSurat::where('nama_surat', 'like', '%Kurang Mampu%')->first();

        if ($masyarakat) {
            if ($domisili) {
                Pengajuan::create([
                    'user_id' => $masyarakat->id,
                    'jenis_surat_id' => $domisili->id,
                    'keperluan' => 'Pindah desa',
                    'status' => 'disetujui',
                    'keterangan' => 'Surat sudah ditandatangani oleh Kepala Desa dan siap dicetak.',
                ]);
            }

            if ($usaha) {
                Pengajuan::create([
                    'user_id' => $masyarakat->id,
                    'jenis_surat_id' => $usaha->id,
                    'keperluan' => 'Persyaratan pengajuan kredit modal usaha di Bank',
                    'status' => 'pending',
                    'keterangan' => 'Dalam antrian verifikasi berkas pendukung.',
                ]);
            }

            if ($kurangMampu) {
                Pengajuan::create([
                    'user_id' => $masyarakat->id,
                    'jenis_surat_id' => $kurangMampu->id,
                    'keperluan' => 'Pengajuan beasiswa kuliah di Universitas',
                    'status' => 'ditolak',
                    'keterangan' => 'Dokumen tidak disetujui karena berkas pendapatan orang tua melebihi kriteria yang ditetapkan.',
                ]);
            }
        }
    }
}
