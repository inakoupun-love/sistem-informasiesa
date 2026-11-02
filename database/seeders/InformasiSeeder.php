<?php

namespace Database\Seeders;

use App\Models\Informasi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        Informasi::firstOrCreate(
            ['judul' => 'Kerja Bakti Massal Kebersihan Lingkungan Desa'],
            [
                'user_id' => $adminId,
                'kategori' => 'Kegiatan',
                'konten' => '<p>Diberitahukan kepada seluruh warga Desa Kalinaun bahwa pada hari <strong>Minggu, 2 Agustus 2026</strong>, akan diadakan kegiatan <strong>Kerja Bakti Massal</strong> untuk membersihkan saluran air dan fasilitas umum desa.</p><p>Kegiatan akan dimulai pukul <strong>07.00 WITA</strong>. Harap membawa peralatan kebersihan masing-masing. Terima kasih atas partisipasi aktif seluruh warga.</p>',
            ]
        );

        Informasi::firstOrCreate(
            ['judul' => 'Penyaluran Bantuan Langsung Tunai (BLT) Tahap 3'],
            [
                'user_id' => $adminId,
                'kategori' => 'Pengumuman',
                'konten' => '<p>Pemerintah Desa Kalinaun mengumumkan bahwa penyaluran <strong>Bantuan Langsung Tunai (BLT) Tahap 3</strong> bagi keluarga penerima manfaat akan dilaksanakan pada:</p><ul><li><strong>Hari/Tanggal:</strong> Rabu, 5 Agustus 2026</li><li><strong>Waktu:</strong> 09.00 WITA - Selesai</li><li><strong>Tempat:</strong> Kantor Balai Desa Kalinaun</li></ul><p>Penerima wajib membawa <strong>KTP Asli</strong> dan <strong>Kartu Keluarga (KK)</strong> untuk proses verifikasi. Pembagian tidak dapat diwakilkan kecuali menyertakan surat kuasa bermaterai.</p>',
            ]
        );

        Informasi::firstOrCreate(
            ['judul' => 'Sosialisasi Program Ketahanan Pangan Desa Kalinaun'],
            [
                'user_id' => $adminId,
                'kategori' => 'Umum',
                'konten' => '<p>Dalam rangka menyukseskan program ketahanan pangan nasional, Desa Kalinaun mengadakan sosialisasi budidaya tanaman hortikultura skala pekarangan rumah tangga bagi ibu-ibu PKK dan kelompok tani.</p><p>Acara dilaksanakan besok pagi di Balai Pertemuan Desa. Disediakan <strong>bibit tanaman sayur gratis</strong> bagi seluruh peserta yang hadir.</p>',
            ]
        );

        Informasi::firstOrCreate(
            ['judul' => 'Pendaftaran Beasiswa Pendidikan Anak Berprestasi'],
            [
                'user_id' => $adminId,
                'kategori' => 'Pengumuman',
                'konten' => '<p>Telah dibuka pendaftaran program beasiswa pendidikan untuk anak sekolah tingkat SD, SMP, dan SMA dari keluarga kurang mampu yang berprestasi akademik. Formulir dapat diambil di kantor desa atau diajukan secara online melalui portal SIPAKAL.</p><p>Batas akhir penyerahan berkas tanggal <strong>15 Agustus 2026</strong>.</p>',
            ]
        );
    }
}
