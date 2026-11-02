<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = User::where('role', 'masyarakat')->first();
        if ($masyarakat) {
            Laporan::create([
                'user_id' => $masyarakat->id,
                'judul' => 'Lampu Jalan Mati di RT 03',
                'isi_laporan' => 'Mohon bantuan untuk perbaikan fasilitas penerangan jalan di RT 03 dekat jembatan penyeberangan karena lampu jalannya sudah mati selama 3 hari berturut-turut, jalan menjadi sangat gelap pada malam hari.',
                'status' => 'pending',
            ]);

            Laporan::create([
                'user_id' => $masyarakat->id,
                'judul' => 'Tumpukan Sampah Liar di Pinggir Jalan Raya',
                'isi_laporan' => 'Ada tumpukan sampah liar di pinggir jalan raya utama dekat persimpangan masuk RT 01. Baunya mulai menyengat dan mengganggu pengguna jalan serta warga sekitar.',
                'status' => 'diproses',
            ]);

            Laporan::create([
                'user_id' => $masyarakat->id,
                'judul' => 'Saluran Air Tersumbat Menyebabkan Genangan',
                'isi_laporan' => 'Saluran pembuangan air di sekitar RT 02 tersumbat akibat tumpukan pasir dan sampah. Ketika hujan deras kemarin, air meluap dan menggenangi halaman rumah warga.',
                'status' => 'selesai',
            ]);
        }
    }
}
