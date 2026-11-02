<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Welcome page
Route::get('/', function () {
    $informasis = \App\Models\Informasi::orderBy('created_at', 'desc')->get();
    $kategoriInformasis = \App\Models\Informasi::select('kategori')->distinct()->whereNotNull('kategori')->get();
    return view('welcome', compact('informasis', 'kategoriInformasis'));
})->name('welcome');

Route::get('/informasi/{id}', function ($id) {
    $info = \App\Models\Informasi::with('user')->findOrFail($id);
    return view('informasi_detail', compact('info'));
})->name('informasi.detail');

// Cek Bantuan Sosial
Route::get('/cek-bansos', [\App\Http\Controllers\CekBansosController::class, 'index'])->name('cekbansos');

// Profil Desa
Route::get('/profil-desa', [\App\Http\Controllers\ProfilDesaController::class, 'index'])->name('profil-desa');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Admin Login
    Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
    
    // Kepala Desa Login
    Route::get('/login/kepala-desa', [AuthController::class, 'showKepalaDesaLogin'])->name('login.kepala_desa');
    
    // Masyarakat Login & Register
    Route::get('/login/masyarakat', [AuthController::class, 'showMasyarakatLogin'])->name('login.masyarakat');
    
    // Halaman login gabungan (Masyarakat | Admin & Kepala Desa)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/dashboard-redirect', [AuthController::class, 'dashboardRedirect'])->name('dashboard.redirect')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Pengguna
    Route::get('/pengguna', [\App\Http\Controllers\AdminController::class, 'kelolaPengguna'])->name('pengguna');
    Route::put('/pengguna/{id}', [\App\Http\Controllers\AdminController::class, 'updatePengguna'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [\App\Http\Controllers\AdminController::class, 'destroyPengguna'])->name('pengguna.destroy');

    // Pengajuan Surat
    Route::get('/pengajuan', [\App\Http\Controllers\AdminController::class, 'kelolaPengajuan'])->name('pengajuan');
    Route::put('/pengajuan/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateStatusPengajuan'])->name('pengajuan.update_status');
    Route::delete('/pengajuan/{id}', [\App\Http\Controllers\AdminController::class, 'destroyPengajuan'])->name('pengajuan.destroy');
    Route::get('/pengajuan/{id}/cetak', [\App\Http\Controllers\AdminController::class, 'cetakPengajuan'])->name('pengajuan.cetak');
    Route::post('/pengajuan/{id}/kirim-wa', [\App\Http\Controllers\AdminController::class, 'kirimNotifikasiPengajuan'])->name('pengajuan.kirim_wa');

    // Bansos
    Route::get('/bansos', [\App\Http\Controllers\AdminController::class, 'kelolaBansos'])->name('bansos');
    Route::put('/bansos/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateStatusBansos'])->name('bansos.update_status');
    Route::post('/bansos/{id}/usulkan', [\App\Http\Controllers\AdminController::class, 'usulkanBansos'])->name('bansos.usulkan');
    Route::delete('/bansos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyBansos'])->name('bansos.destroy');
    Route::post('/bansos/{id}/kirim-wa', [\App\Http\Controllers\AdminController::class, 'kirimNotifikasiBansos'])->name('bansos.kirim_wa');

    // Informasi
    Route::get('/informasi', [\App\Http\Controllers\AdminController::class, 'kelolaInformasi'])->name('informasi');
    Route::post('/informasi', [\App\Http\Controllers\AdminController::class, 'storeInformasi'])->name('informasi.store');
    Route::post('/informasi/upload-image', [\App\Http\Controllers\AdminController::class, 'uploadImage'])->name('informasi.upload_image');
    Route::put('/informasi/{id}', [\App\Http\Controllers\AdminController::class, 'updateInformasi'])->name('informasi.update');
    Route::delete('/informasi/{id}', [\App\Http\Controllers\AdminController::class, 'destroyInformasi'])->name('informasi.destroy');

    // Laporan
    Route::get('/laporan', [\App\Http\Controllers\AdminController::class, 'kelolaLaporan'])->name('laporan');
    Route::put('/laporan/{id}/status', [\App\Http\Controllers\AdminController::class, 'updateStatusLaporan'])->name('laporan.update_status');
    Route::delete('/laporan/{id}', [\App\Http\Controllers\AdminController::class, 'destroyLaporan'])->name('laporan.destroy');

    // Master Data
    Route::get('/jenis-surat', [\App\Http\Controllers\AdminController::class, 'jenisSurat'])->name('jenis_surat');
    Route::post('/jenis-surat', [\App\Http\Controllers\AdminController::class, 'storeJenisSurat'])->name('jenis_surat.store');
    Route::put('/jenis-surat/{id}', [\App\Http\Controllers\AdminController::class, 'updateJenisSurat'])->name('jenis_surat.update');
    Route::delete('/jenis-surat/{id}', [\App\Http\Controllers\AdminController::class, 'destroyJenisSurat'])->name('jenis_surat.destroy');

    Route::get('/jenis-bansos', [\App\Http\Controllers\AdminController::class, 'jenisBansos'])->name('jenis_bansos');
    Route::post('/jenis-bansos', [\App\Http\Controllers\AdminController::class, 'storeJenisBansos'])->name('jenis_bansos.store');
    Route::put('/jenis-bansos/{id}', [\App\Http\Controllers\AdminController::class, 'updateJenisBansos'])->name('jenis_bansos.update');
    Route::delete('/jenis-bansos/{id}', [\App\Http\Controllers\AdminController::class, 'destroyJenisBansos'])->name('jenis_bansos.destroy');
    
    Route::get('/profil', [\App\Http\Controllers\AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [\App\Http\Controllers\AdminController::class, 'updateProfil'])->name('profil.update');
});

// Kepala Desa Routes
Route::middleware(['auth', 'role:kepala_desa'])->prefix('kepala-desa')->name('kepala_desa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\KepalaDesaController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan', [\App\Http\Controllers\KepalaDesaController::class, 'pengajuan'])->name('pengajuan');
    Route::put('/pengajuan/{id}/status', [\App\Http\Controllers\KepalaDesaController::class, 'updateStatusPengajuan'])->name('pengajuan.update_status');
    Route::get('/bansos', [\App\Http\Controllers\KepalaDesaController::class, 'bansos'])->name('bansos');
    Route::put('/bansos/{id}/status', [\App\Http\Controllers\KepalaDesaController::class, 'updateStatusBansos'])->name('bansos.update_status');
    Route::get('/pengaduan', [\App\Http\Controllers\KepalaDesaController::class, 'laporan'])->name('laporan');
    Route::put('/pengaduan/{id}/terima', [\App\Http\Controllers\KepalaDesaController::class, 'terimaLaporan'])->name('laporan.terima');
    Route::get('/profil', [\App\Http\Controllers\KepalaDesaController::class, 'profil'])->name('profil');
    Route::put('/profil', [\App\Http\Controllers\KepalaDesaController::class, 'updateProfil'])->name('profil.update');
});

// Masyarakat Routes
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->name('masyarakat.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\MasyarakatController::class, 'dashboard'])->name('dashboard');
    Route::get('/buat-pengajuan', [\App\Http\Controllers\MasyarakatController::class, 'buatPengajuan'])->name('buat_pengajuan');
    Route::post('/buat-pengajuan', [\App\Http\Controllers\MasyarakatController::class, 'storePengajuan'])->name('store_pengajuan');
    Route::get('/buat-bansos', [\App\Http\Controllers\MasyarakatController::class, 'buatBansos'])->name('buat_bansos');
    Route::post('/buat-bansos', [\App\Http\Controllers\MasyarakatController::class, 'storeBansos'])->name('store_bansos');
    Route::get('/buat-laporan', [\App\Http\Controllers\MasyarakatController::class, 'buatLaporan'])->name('buat_laporan');
    Route::post('/buat-laporan', [\App\Http\Controllers\MasyarakatController::class, 'storeLaporan'])->name('store_laporan');
    Route::get('/informasi', [\App\Http\Controllers\MasyarakatController::class, 'informasi'])->name('informasi');
    Route::get('/riwayat', [\App\Http\Controllers\MasyarakatController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [\App\Http\Controllers\MasyarakatController::class, 'profil'])->name('profil');
    Route::put('/profil', [\App\Http\Controllers\MasyarakatController::class, 'updateProfil'])->name('profil.update');
});

// Notification Routes (untuk semua role yang authenticated)
Route::middleware('auth')->prefix('api/notifications')->name('api.notifications.')->group(function () {
    Route::get('/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('unread');
    Route::get('/all', [\App\Http\Controllers\NotificationController::class, 'getAll'])->name('all');
    Route::get('/count', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('count');
    Route::put('/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark_as_read');
    Route::put('/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark_all_as_read');
    Route::delete('/{notification}', [\App\Http\Controllers\NotificationController::class, 'delete'])->name('delete');
});

