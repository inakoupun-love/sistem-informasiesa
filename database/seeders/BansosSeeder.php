<?php

namespace Database\Seeders;

use App\Models\Bansos;
use App\Models\JenisBansos;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BansosSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = User::where('role', 'masyarakat')->first();

        // Create Jenis Bansos (previously Bansos Programs)
        $jenisBansos1 = JenisBansos::create([
            'nama_bansos' => 'Bantuan Langsung Tunai (BLT)',
            'keterangan' => 'Program bantuan langsung tunai untuk keluarga kurang mampu. Syarat: Terdaftar sebagai keluarga kurang mampu, Memiliki KTP dan KK, Tidak menerima bantuan serupa dari program lain. Kuota: 50. Nominal: 500000.',
        ]);

        $jenisBansos2 = JenisBansos::create([
            'nama_bansos' => 'Bantuan Pangan Non Tunai (BPNT)',
            'keterangan' => 'Program bantuan pangan untuk keluarga kurang mampu. Syarat: Terdaftar sebagai keluarga kurang mampu, Memiliki KTP dan KK. Kuota: 100. Nominal: 300000.',
        ]);

        $jenisBansos3 = JenisBansos::create([
            'nama_bansos' => 'Beasiswa Pendidikan',
            'keterangan' => 'Program beasiswa untuk siswa berprestasi dari keluarga kurang mampu. Syarat: Siswa aktif di sekolah, Nilai rata-rata minimal 7.0. Kuota: 30. Nominal: 1000000.',
        ]);

        // Create sample applications/submissions (previously PenerimaBansos)
        if ($masyarakat) {
            Bansos::create([
                'jenis_bansos_id' => $jenisBansos1->id,
                'user_id' => $masyarakat->id,
                'alasan' => 'Terdampak kondisi ekonomi keluarga kurang mampu',
                'status' => 'disetujui',
                'keterangan' => 'Telah disetujui, dana telah dicairkan.',
            ]);

            Bansos::create([
                'jenis_bansos_id' => $jenisBansos2->id,
                'user_id' => $masyarakat->id,
                'alasan' => 'Membutuhkan bantuan pangan untuk kebutuhan sehari-hari',
                'status' => 'pending',
                'keterangan' => 'Menunggu proses verifikasi berkas.',
            ]);
        }
    }
}
