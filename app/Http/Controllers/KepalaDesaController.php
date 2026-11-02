<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Bansos;
use App\Models\Laporan;
use App\Models\Pengajuan;
use App\Models\Notification;
use App\Services\FonnteService;
use App\Traits\SendsNotifications;

class KepalaDesaController extends Controller
{
    public function dashboard()
    {
        return view('kepaladesa.dashboardkades');
    }

    public function pengajuan()
    {
        $pengajuans = Pengajuan::with(['user', 'jenisSurat'])->orderBy('created_at', 'desc')->get();
        return view('kepaladesa.dashboard.tinjaupengajuan', compact('pengajuans'));
    }

    public function updateStatusPengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $previousStatus = $pengajuan->status;
        $pengajuan->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        // Send notifications based on status change
        if ($request->status === 'disetujui' && $previousStatus !== 'disetujui') {
            // Send WhatsApp notification
            $sent = app(FonnteService::class)->sendPengajuanNotification(
                $pengajuan->load(['user', 'jenisSurat']),
                'approved'
            );

            Notification::create([
                'user_id' => $pengajuan->user_id,
                'type' => 'pengajuan_disetujui',
                'title' => 'Pengajuan Surat Disetujui',
                'message' => "Pengajuan surat {$pengajuan->jenisSurat?->nama_surat} Anda telah disetujui oleh Kepala Desa.",
                'related_model' => 'Pengajuan',
                'related_id' => $pengajuan->id,
            ]);

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui dan notifikasi telah dikirim.');
        } elseif ($request->status === 'ditolak' && $previousStatus !== 'ditolak') {
            // Send WhatsApp notification
            $sent = app(FonnteService::class)->sendPengajuanNotification(
                $pengajuan->load(['user', 'jenisSurat']),
                'rejected'
            );

            Notification::create([
                'user_id' => $pengajuan->user_id,
                'type' => 'pengajuan_ditolak',
                'title' => 'Pengajuan Surat Ditolak',
                'message' => "Pengajuan surat {$pengajuan->jenisSurat?->nama_surat} Anda telah ditolak. Keterangan: {$request->keterangan}",
                'related_model' => 'Pengajuan',
                'related_id' => $pengajuan->id,
                'data' => ['keterangan' => $request->keterangan],
            ]);

            return redirect()->back()->with(
                $sent ? 'success' : 'warning',
                $sent ? 'Status pengajuan berhasil diperbarui dan notifikasi ditolak telah dikirim.' : 'Status pengajuan berhasil diperbarui, tetapi notifikasi WhatsApp gagal dikirim. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
            );
        }

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function bansos()
    {
        $bansos = Bansos::with(['user', 'jenisBansos'])
            ->where('status', 'diusulkan')
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayatBansos = Bansos::with(['user', 'jenisBansos'])
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('kepaladesa.dashboard.tinjaubansos', compact('bansos', 'riwayatBansos'));
    }

    public function updateStatusBansos(Request $request, $id)
    {
        $bansos = Bansos::findOrFail($id);
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $previousStatus = $bansos->status;
        $bansos->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        if ($request->status === 'disetujui' && $previousStatus !== 'disetujui') {
            // Notify admin so they can send the notification to the masyarakat
            SendsNotifications::sendNotificationToRole(
                'admin',
                'bansos_usulan_disetujui',
                'Usulan Bansos Disetujui',
                "Usulan bansos {$bansos->jenisBansos?->nama_bansos} dari {$bansos->nama_lengkap} telah disetujui Kepala Desa. Silakan kirim notifikasi kepada pemohon.",
                'Bansos',
                $bansos->id
            );

            return redirect()->back()->with('success', 'Usulan bansos disetujui. Admin akan mengirim notifikasi kepada pemohon.');
        } elseif ($request->status === 'ditolak' && $previousStatus !== 'ditolak') {
            // Send WhatsApp notification
            $sent = app(FonnteService::class)->sendBansosNotification(
                $bansos->load(['user', 'jenisBansos']),
                'rejected'
            );

            Notification::create([
                'user_id' => $bansos->user_id,
                'type' => 'bansos_ditolak',
                'title' => 'Permohonan Bansos Ditolak',
                'message' => "Permohonan {$bansos->jenisBansos?->nama_bansos} Anda telah ditolak. Keterangan: {$request->keterangan}",
                'related_model' => 'Bansos',
                'related_id' => $bansos->id,
                'data' => ['keterangan' => $request->keterangan],
            ]);

            return redirect()->back()->with(
                $sent ? 'success' : 'warning',
                $sent ? 'Status permohonan bansos berhasil diperbarui dan notifikasi ditolak telah dikirim.' : 'Status permohonan bansos berhasil diperbarui, tetapi notifikasi WhatsApp gagal dikirim. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
            );
        }

        return redirect()->back()->with('success', 'Status permohonan bansos berhasil diperbarui.');
    }

    public function laporan()
    {
        $laporans = Laporan::with('user')->orderBy('created_at', 'desc')->get();
        return view('kepaladesa.dashboard.pengaduan', compact('laporans'));
    }

    public function terimaLaporan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $laporan->update([
            'status' => 'diterima'
        ]);

        Notification::create([
            'user_id' => $laporan->user_id,
            'type' => 'pengaduan_diterima',
            'title' => 'Pengaduan Diterima',
            'message' => "Pengaduan \"{$laporan->judul}\" Anda telah diterima oleh Kepala Desa dan akan ditindaklanjuti.",
            'related_model' => 'Laporan',
            'related_id' => $laporan->id,
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil diterima dan akan ditindaklanjuti.');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('kepaladesa.dashboard.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'nik' => 'nullable|string|max:20',
            'signature' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'remove_signature' => 'nullable|boolean',
        ]);

        $signaturePath = $user->signature_path;
        if ($request->boolean('remove_signature') && $signaturePath) {
            Storage::disk('public')->delete($signaturePath);
            $signaturePath = null;
        }

        if ($request->hasFile('signature')) {
            if ($signaturePath) {
                Storage::disk('public')->delete($signaturePath);
            }

            $signaturePath = $request->file('signature')->store('signatures', 'public');
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'nik' => $request->nik,
            'signature_path' => $signaturePath,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
