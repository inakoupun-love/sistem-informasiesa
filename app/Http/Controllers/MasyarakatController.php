<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\Bansos;
use App\Models\Laporan;
use App\Models\Informasi;
use App\Models\JenisSurat;
use App\Models\JenisBansos;
use App\Models\Notification;
use App\Traits\SendsNotifications;

class MasyarakatController extends Controller
{
    public function dashboard()
    {
        return view('masyarakat.index');
    }

    public function buatPengajuan()
    {
        $jenisSurats = JenisSurat::all();
        return view('masyarakat.beranda.buatpengajuan', compact('jenisSurats'));
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan' => 'required|string',
            'dokumen_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $dokumenPath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPath = $request->file('dokumen_pendukung')->store('pengajuan', 'public');
        }

        $pengajuan = Pengajuan::create([
            'user_id' => Auth::id(),
            'jenis_surat_id' => $request->jenis_surat_id,
            'keperluan' => $request->keperluan,
            'dokumen_pendukung' => $dokumenPath,
            'status' => 'pending',
        ]);

        // Send notification to user
        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'pengajuan_baru',
            'title' => 'Pengajuan Surat Dibuat',
            'message' => 'Pengajuan surat Anda telah dibuat dan sedang menunggu review dari kepala desa.',
            'related_model' => 'Pengajuan',
            'related_id' => $pengajuan->id,
        ]);

        // Send notification to kepala_desa role about new pengajuan
        SendsNotifications::sendNotificationToRole(
            'kepala_desa',
            'pengajuan_baru',
            'Pengajuan Surat Baru',
            "Ada pengajuan surat baru dari {$pengajuan->user->name} untuk surat {$pengajuan->jenisSurat->nama_surat}",
            'Pengajuan',
            $pengajuan->id
        );

        return redirect()->route('masyarakat.riwayat')->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function buatBansos()
    {
        $programs = [
            'BLT Dana Desa',
            'PKH',
            'Bantuan Sembako',
            'Bantuan Sosial Daerah',
        ];

        return view('masyarakat.beranda.buatpermintaanbansos', compact('programs'));
    }

    public function storeBansos(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:20',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+()\-\s]+$/',
            'status_tempat_tinggal' => 'required|string|max:50',
            'desa' => 'required|string|max:100',
            'program' => 'required|string',
            'kondisi_ekonomi' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'dokumen_kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'dokumen_rumah' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'rt_rw.required' => 'RT/RW harus diisi',
            'no_hp.required' => 'Nomor HP aktif harus diisi',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka dan simbol telepon yang valid',
            'status_tempat_tinggal.required' => 'Status tempat tinggal harus dipilih',
            'desa.required' => 'Desa harus diisi',
            'program.required' => 'Program bansos harus dipilih',
            'kondisi_ekonomi.required' => 'Kondisi ekonomi keluarga harus diisi',
            'dokumen_ktp.required' => 'Dokumen KTP harus diunggah',
            'dokumen_kk.required' => 'Dokumen KK harus diunggah',
            'dokumen_rumah.required' => 'Foto kondisi rumah harus diunggah',
        ]);

        // Map selected program to a master jenis_bansos record (keeps admin views working)
        $jenisBansos = JenisBansos::firstOrCreate(['nama_bansos' => $request->program]);

        $bansos = Bansos::create([
            'user_id' => Auth::id(),
            'jenis_bansos_id' => $jenisBansos->id,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
            'no_hp' => $request->no_hp,
            'status_tempat_tinggal' => $request->status_tempat_tinggal,
            'desa' => $request->desa,
            'kondisi_ekonomi' => $request->kondisi_ekonomi,
            'dokumen_ktp' => $request->file('dokumen_ktp')->store('bansos', 'public'),
            'dokumen_kk' => $request->file('dokumen_kk')->store('bansos', 'public'),
            'dokumen_rumah' => $request->file('dokumen_rumah')->store('bansos', 'public'),
            'status' => 'pending',
        ]);

        // Send notification to user
        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'bansos_baru',
            'title' => 'Permohonan Bansos Dibuat',
            'message' => 'Permohonan bansos Anda telah dibuat dan sedang menunggu review dari kepala desa.',
            'related_model' => 'Bansos',
            'related_id' => $bansos->id,
        ]);

        // Send notification to kepala_desa role about new bansos request
        SendsNotifications::sendNotificationToRole(
            'kepala_desa',
            'bansos_baru',
            'Permohonan Bansos Baru',
            "Ada permohonan bansos baru dari {$bansos->user->name} untuk {$bansos->jenisBansos->nama_bansos}",
            'Bansos',
            $bansos->id
        );

        return redirect()->route('masyarakat.riwayat')->with('success', 'Permohonan bansos berhasil dikirim.');
    }

    public function buatLaporan()
    {
        return view('masyarakat.beranda.buatlaporan');
    }

    public function storeLaporan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
        ]);

        $laporan = Laporan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
        ]);

        // Send notification to user
        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'laporan_baru',
            'title' => 'Pengaduan Dibuat',
            'message' => 'Pengaduan Anda telah dibuat dan sedang menunggu review dari admin.',
            'related_model' => 'Laporan',
            'related_id' => $laporan->id,
        ]);

        // Send notification to admin role about new laporan
        SendsNotifications::sendNotificationToRole(
            'admin',
            'laporan_baru',
            'Pengaduan Baru Masuk',
            "Ada pengaduan baru dari {$laporan->user->name} dengan judul: {$laporan->judul}",
            'Laporan',
            $laporan->id
        );

        // Send notification to kepala desa role so they can receive it
        SendsNotifications::sendNotificationToRole(
            'kepala_desa',
            'laporan_baru',
            'Pengaduan Baru Masuk',
            "Ada pengaduan baru dari {$laporan->user->name} dengan judul: {$laporan->judul}",
            'Laporan',
            $laporan->id
        );

        return redirect()->route('masyarakat.riwayat')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function informasi()
    {
        $informasi = Informasi::with('user')->orderBy('created_at', 'desc')->get();
        return view('masyarakat.beranda.informasi', compact('informasi'));
    }

    public function riwayat()
    {
        $user_id = Auth::id();
        $pengajuans = Pengajuan::with('jenisSurat')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        $bansos = Bansos::with('jenisBansos')->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        $laporans = Laporan::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return view('masyarakat.beranda.riwayat', compact('pengajuans', 'bansos', 'laporans'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('masyarakat.beranda.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'nik' => 'nullable|string|max:20',
            'phone' => 'required|string|max:20|regex:/^[0-9+()\-\s]+$/',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'agama' => 'required|string|max:30',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'alamat' => 'required|string|max:1000',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
