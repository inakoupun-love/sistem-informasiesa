<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\Bansos;
use App\Models\Informasi;
use App\Models\Laporan;
use App\Models\JenisSurat;
use App\Models\JenisBansos;
use App\Models\Notification;
use App\Services\FonnteService;
use App\Traits\SendsNotifications;

class AdminController extends Controller
{
    public function dashboard()
    {
        $statistics = [
            'activeUsers' => User::where('status', 'active')->count(),
            'totalPengajuans' => Pengajuan::count(),
            'totalBansos' => Bansos::count(),
            'pendingLaporans' => Laporan::where('status', 'pending')->count(),
        ];

        return view('admin.dashboardadmin', compact('statistics'));
    }

    // --- Pengguna ---
    public function kelolaPengguna()
    {
        $users = User::where('role', 'masyarakat')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.kelolapengguna', compact('users'));
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:admin,kepala_desa,masyarakat',
            'status' => 'required|in:active,inactive,suspended'
        ]);
        
        $user->update([
            'role' => $request->role,
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }

    // --- Pengajuan Surat ---
    public function kelolaPengajuan()
    {
        $pengajuans = Pengajuan::with(['user', 'jenisSurat'])->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.kelolapengajuan', compact('pengajuans'));
    }

    public function updateStatusPengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
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

            // Send in-app notification
            Notification::create([
                'user_id' => $pengajuan->user_id,
                'type' => 'pengajuan_disetujui',
                'title' => 'Pengajuan Surat Disetujui',
                'message' => "Pengajuan surat {$pengajuan->jenisSurat?->nama_surat} Anda telah disetujui.",
                'related_model' => 'Pengajuan',
                'related_id' => $pengajuan->id,
            ]);

            return redirect()->back()->with(
                $sent ? 'success' : 'warning',
                $sent ? 'Status pengajuan berhasil diperbarui dan notifikasi WhatsApp berhasil dikirim.' : 'Status pengajuan berhasil diperbarui, tetapi notifikasi WhatsApp gagal dikirim. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
            );
        } elseif ($request->status === 'ditolak' && $previousStatus !== 'ditolak') {
            // Send WhatsApp notification
            $sent = app(FonnteService::class)->sendPengajuanNotification(
                $pengajuan->load(['user', 'jenisSurat']),
                'rejected'
            );

            // Send rejection notification
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
                $sent ? 'Status pengajuan berhasil diperbarui dan notifikasi pengajuan ditolak telah dikirim.' : 'Status pengajuan berhasil diperbarui, tetapi notifikasi WhatsApp gagal dikirim. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
            );
        }
        
        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroyPengajuan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->delete();
        return redirect()->back()->with('success', 'Pengajuan surat berhasil dihapus.');
    }

    public function cetakPengajuan($id)
    {
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->findOrFail($id);

        if ($pengajuan->status === 'disetujui') {
            app(FonnteService::class)->sendPengajuanNotification($pengajuan, 'printed');
        }

        return view('admin.dashboard.cetakpengajuan', compact('pengajuan'));
    }

    public function kirimNotifikasiPengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan::with(['user', 'jenisSurat'])->findOrFail($id);

        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()->with('warning', 'Surat hanya dapat dikirim via WhatsApp jika pengajuan sudah disetujui.');
        }

        $message = trim($request->input('pesan') ?? '');
        if ($message === '') {
            $message = "Halo {$pengajuan->user?->name}, surat {$pengajuan->jenisSurat?->nama_surat} Anda telah selesai dan dapat diambil di Kantor Desa Kalinaun.";
        }

        $sent = app(FonnteService::class)->sendCustomMessage(
            $pengajuan->user?->phone,
            $message,
            ['pengajuan_id' => $pengajuan->id, 'type' => 'manual_pengajuan']
        );

        Notification::create([
            'user_id' => $pengajuan->user_id,
            'type' => 'surat_dikirim',
            'title' => 'Surat Selesai dan Siap Diambil',
            'message' => "Surat {$pengajuan->jenisSurat?->nama_surat} Anda telah selesai dan dapat diambil di Kantor Desa Kalinaun.",
            'related_model' => 'Pengajuan',
            'related_id' => $pengajuan->id,
        ]);

        return redirect()->back()->with(
            $sent ? 'success' : 'warning',
            $sent ? "Surat berhasil dikirim ke WhatsApp {$pengajuan->user?->name}." : 'Surat gagal dikirim via WhatsApp. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
        );
    }

    // --- Bansos ---
    public function kelolaBansos()
    {
        $bansos = Bansos::with(['user', 'jenisBansos'])->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.kelolabansos', compact('bansos'));
    }

    public function updateStatusBansos(Request $request, $id)
    {
        $bansos = Bansos::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $previousStatus = $bansos->status;
        $bansos->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        // Notify masyarakat when the request is rejected
        if ($request->status === 'ditolak' && $previousStatus !== 'ditolak') {
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

    public function usulkanBansos(Request $request, $id)
    {
        $bansos = Bansos::with('jenisBansos')->findOrFail($id);
        $request->validate([
            'keterangan' => 'nullable|string'
        ]);

        $bansos->update([
            'status' => 'diusulkan',
            'keterangan' => $request->keterangan,
        ]);

        // Notify kepala desa that there is a new usulan to review
        SendsNotifications::sendNotificationToRole(
            'kepala_desa',
            'bansos_diusulkan',
            'Usulan Bansos Baru',
            "Admin mengusulkan permohonan {$bansos->jenisBansos?->nama_bansos} dari {$bansos->nama_lengkap} untuk ditinjau dan disetujui.",
            'Bansos',
            $bansos->id
        );

        return redirect()->back()->with('success', 'Permohonan bansos berhasil diverifikasi dan diusulkan kepada Kepala Desa.');
    }

    public function destroyBansos($id)
    {
        $bansos = Bansos::findOrFail($id);
        $bansos->delete();
        return redirect()->back()->with('success', 'Permohonan bansos berhasil dihapus.');
    }

    public function kirimNotifikasiBansos(Request $request, $id)
    {
        $bansos = Bansos::with(['user', 'jenisBansos'])->findOrFail($id);

        if ($bansos->status !== 'disetujui') {
            return redirect()->back()->with('warning', 'Notifikasi bansos hanya dapat dikirim via WhatsApp jika permohonan sudah disetujui.');
        }

        $message = trim($request->input('pesan') ?? '');
        if ($message === '') {
            $message = "Halo {$bansos->user?->name}, permohonan {$bansos->jenisBansos?->nama_bansos} Anda telah disetujui dan Anda terdaftar sebagai penerima bansos. Kami akan menghubungi Anda untuk proses selanjutnya.";
        }

        $sent = app(FonnteService::class)->sendCustomMessage(
            $bansos->no_hp ?? $bansos->user?->phone,
            $message,
            ['bansos_id' => $bansos->id, 'type' => 'manual_bansos']
        );

        Notification::create([
            'user_id' => $bansos->user_id,
            'type' => 'bansos_terima',
            'title' => 'Anda Terdaftar sebagai Penerima Bansos',
            'message' => "Permohonan {$bansos->jenisBansos?->nama_bansos} Anda telah disetujui dan Anda terdaftar sebagai penerima bansos.",
            'related_model' => 'Bansos',
            'related_id' => $bansos->id,
        ]);

        return redirect()->back()->with(
            $sent ? 'success' : 'warning',
            $sent ? "Notifikasi penerima bansos berhasil dikirim ke WhatsApp {$bansos->user?->name}." : 'Notifikasi bansos gagal dikirim via WhatsApp. Periksa token, koneksi, perangkat Fonnte, dan log aplikasi.'
        );
    }

    // --- Informasi ---
    public function kelolaInformasi()
    {
        $informasi = Informasi::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.kelolainformasi', compact('informasi'));
    }

    public function storeInformasi(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'konten' => 'required|string'
        ]);
        
        Informasi::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'konten' => $request->konten
        ]);
        
        return redirect()->back()->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
        
            $request->file('upload')->move(public_path('images/uploads'), $fileName);
        
            $url = '/images/uploads/' . $fileName;
            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        }
        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Gagal mengunggah gambar.'
            ]
        ]);
    }

    public function updateInformasi(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:50',
            'konten' => 'required|string'
        ]);
        
        $informasi->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'konten' => $request->konten
        ]);
        
        return redirect()->back()->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroyInformasi($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();
        return redirect()->back()->with('success', 'Informasi berhasil dihapus.');
    }

    // --- Laporan ---
    public function kelolaLaporan()
    {
        $laporans = Laporan::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.kelolalaporan', compact('laporans'));
    }

    public function updateStatusLaporan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,diterima,diproses,selesai'
        ]);
        
        $laporan->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function destroyLaporan($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();
        return redirect()->back()->with('success', 'Pengaduan berhasil dihapus.');
    }

    // --- Profil ---
    public function profil()
    {
        $user = Auth::user();
        return view('admin.dashboard.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    // --- Master Data: Jenis Surat ---
    public function jenisSurat()
    {
        $jenisSurats = JenisSurat::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.jenissurat', compact('jenisSurats'));
    }

    public function storeJenisSurat(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);
        
        JenisSurat::create([
            'nama_surat' => $request->nama_surat,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->back()->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function updateJenisSurat(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);
        
        $jenisSurat->update([
            'nama_surat' => $request->nama_surat,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->back()->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function destroyJenisSurat($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();
        return redirect()->back()->with('success', 'Jenis Surat berhasil dihapus.');
    }

    // --- Master Data: Jenis Bansos ---
    public function jenisBansos()
    {
        $jenisBansos = JenisBansos::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.jenisbansos', compact('jenisBansos'));
    }

    public function storeJenisBansos(Request $request)
    {
        $request->validate([
            'nama_bansos' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);
        
        JenisBansos::create([
            'nama_bansos' => $request->nama_bansos,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->back()->with('success', 'Jenis Bansos berhasil ditambahkan.');
    }

    public function updateJenisBansos(Request $request, $id)
    {
        $jenisBansos = JenisBansos::findOrFail($id);
        $request->validate([
            'nama_bansos' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);
        
        $jenisBansos->update([
            'nama_bansos' => $request->nama_bansos,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->back()->with('success', 'Jenis Bansos berhasil diperbarui.');
    }

    public function destroyJenisBansos($id)
    {
        $jenisBansos = JenisBansos::findOrFail($id);
        $jenisBansos->delete();
        return redirect()->back()->with('success', 'Jenis Bansos berhasil dihapus.');
    }
}
