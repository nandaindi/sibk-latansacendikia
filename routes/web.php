<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\BK\DashboardController as BKController;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('siswa.dashboard');
    }
    return view('splash');
});

// Redirect old reset-password GET to forgot-password
Route::get('/reset-password', function() {
    return redirect()->route('password.request');
});

// Auth routes
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [LoginController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'reset'])->name('password.update');

// Siswa routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',        [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/panggilan',        [DashboardController::class, 'panggilan'])->name('panggilan');
    Route::get('/detail-panggilan/{id}', [DashboardController::class, 'detailPanggilan'])->name('detail-panggilan');
    Route::post('/terima-panggilan',[DashboardController::class, 'terimaPanggilan'])->name('terima-panggilan');

    Route::get('/pengajuan-online',        [DashboardController::class, 'pengajuanOnline'])->name('pengajuan-online');
    Route::post('/pengajuan-online/store', [DashboardController::class, 'storePengajuanOnline'])->name('pengajuan-online.store');

    Route::get('/pengajuan-offline',        [DashboardController::class, 'pengajuanOffline'])->name('pengajuan-offline');
    Route::post('/pengajuan-offline/store', [DashboardController::class, 'storePengajuanOffline'])->name('pengajuan-offline.store');

    Route::get('/pengajuan-proses',  [DashboardController::class, 'pengajuanProses'])->name('pengajuan-proses');
    Route::get('/pengajuan-ditolak', [DashboardController::class, 'pengajuanDitolak'])->name('pengajuan-ditolak');

    // Konseling aktif
    Route::get('/mulai-konseling',   [DashboardController::class, 'mulaiKonseling'])->name('mulai-konseling');
    Route::get('/chat-konseling',    [DashboardController::class, 'chatKonseling'])->name('chat-konseling');
    Route::get('/konseling-offline', [DashboardController::class, 'konselingOffline'])->name('konseling-offline');

    // Riwayat & Laporan
    Route::get('/riwayat-konseling', [DashboardController::class, 'riwayatKonseling'])->name('riwayat-konseling');
    Route::get('/laporan/{id}',      [DashboardController::class, 'detailLaporan'])->name('detail-laporan');

    // Chat real-time routes (siswa)
    Route::post('/chat/send',   [ChatController::class, 'sendPesan'])->name('chat.send');
    Route::get('/chat/fetch',   [ChatController::class, 'fetchPesan'])->name('chat.fetch');

    // Artikel Edukasi
    Route::get('/artikel',           [DashboardController::class, 'indexArtikel'])->name('artikel.index');
    Route::get('/artikel/{slug}',    [DashboardController::class, 'bacaArtikel'])->name('artikel.show');

    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// BK (Guru Konseling) routes
Route::middleware(['auth', 'role:bk'])->prefix('bk')->name('bk.')->group(function () {
    Route::get('/dashboard',              [BKController::class, 'index'])->name('dashboard');
    Route::get('/panggil-siswa',          [BKController::class, 'panggilSiswa'])->name('panggil-siswa');
    Route::post('/panggil-siswa/store',   [BKController::class, 'storePanggilSiswa'])->name('panggil-siswa.store');
    Route::get('/daftar-pengajuan',              [BKController::class, 'daftarPengajuan'])->name('daftar-pengajuan');
    Route::get('/validasi-pengajuan',            [BKController::class, 'validasiPengajuan'])->name('validasi-pengajuan');
    Route::get('/setujui-pengajuan',             [BKController::class, 'setujuiPengajuan'])->name('setujui-pengajuan');
    Route::post('/setujui-pengajuan/store',      [BKController::class, 'storeSetujuiPengajuan'])->name('setujui-pengajuan.store');
    Route::post('/tolak-pengajuan',              [BKController::class, 'tolakPengajuan'])->name('tolak-pengajuan');
    Route::get('/sesi-konseling',                [BKController::class, 'sesiKonseling'])->name('sesi-konseling');
    Route::get('/detail-sesi',                   [BKController::class, 'detailSesi'])->name('detail-sesi');
    Route::get('/konseling-online',              [BKController::class, 'konselingOnline'])->name('konseling-online');
    Route::get('/form-konseling-offline/{id}',   [BKController::class, 'formKonselingOffline'])->name('form-konseling-offline');
    Route::post('/store-form-konseling-offline', [BKController::class, 'storeFormKonselingOffline'])->name('store-form-konseling-offline');

    // Artikel Management (BK)
    Route::resource('artikel', \App\Http\Controllers\BK\ArtikelController::class);

    Route::get('/laporan-konseling',             [BKController::class, 'laporanKonseling'])->name('laporan-konseling');

    // Chat real-time routes (bk)
    Route::post('/chat/send',    [ChatController::class, 'sendPesan'])->name('chat.send');
    Route::get('/chat/fetch',    [ChatController::class, 'fetchPesan'])->name('chat.fetch');
    Route::post('/selesai-sesi', [ChatController::class, 'selesaiSesi'])->name('selesai-sesi');

    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',          [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kelola-akun',        [\App\Http\Controllers\Admin\DashboardController::class, 'kelolaAkun'])->name('kelola-akun');
    Route::get('/tambah-akun',        [\App\Http\Controllers\Admin\DashboardController::class, 'tambahAkun'])->name('tambah-akun');
    Route::post('/tambah-akun/store', [\App\Http\Controllers\Admin\DashboardController::class, 'storeTambahAkun'])->name('tambah-akun.store');
    Route::get('/detail-akun',        [\App\Http\Controllers\Admin\DashboardController::class, 'detailAkun'])->name('detail-akun');
    Route::delete('/detail-akun',     [\App\Http\Controllers\Admin\DashboardController::class, 'destroyAkun'])->name('detail-akun.destroy');
    Route::get('/edit-akun',          [\App\Http\Controllers\Admin\DashboardController::class, 'editAkun'])->name('edit-akun');
    Route::put('/edit-akun',          [\App\Http\Controllers\Admin\DashboardController::class, 'updateEditAkun'])->name('edit-akun.update');
    Route::get('/kelola-data',        [\App\Http\Controllers\Admin\DashboardController::class, 'kelolaData'])->name('kelola-data');
    Route::get('/kelola-data/tambah', [\App\Http\Controllers\Admin\DashboardController::class, 'tambahData'])->name('kelola-data.tambah');
    Route::post('/kelola-data/tambah', [\App\Http\Controllers\Admin\DashboardController::class, 'storeTambahData'])->name('kelola-data.tambah.store');
    Route::get('/kelola-data/detail', [\App\Http\Controllers\Admin\DashboardController::class, 'detailKonseling'])->name('kelola-data.detail');
    Route::get('/kelola-data/edit-akun', [\App\Http\Controllers\Admin\DashboardController::class, 'editAkunData'])->name('kelola-data.edit-akun');
    Route::put('/kelola-data/edit-akun', [\App\Http\Controllers\Admin\DashboardController::class, 'updateEditAkunData'])->name('kelola-data.edit-akun.update');
    
    Route::get('/kelola-laporan',     [\App\Http\Controllers\Admin\DashboardController::class, 'kelolaLaporan'])->name('kelola-laporan');
    Route::get('/kelola-laporan/detail', [\App\Http\Controllers\Admin\DashboardController::class, 'detailLaporan'])->name('kelola-laporan.detail');
    Route::delete('/kelola-laporan/detail', [\App\Http\Controllers\Admin\DashboardController::class, 'destroyLaporan'])->name('kelola-laporan.destroy');
    Route::get('/kelola-laporan/tambah', [\App\Http\Controllers\Admin\DashboardController::class, 'tambahLaporan'])->name('kelola-laporan.tambah');
    Route::post('/kelola-laporan/tambah', [\App\Http\Controllers\Admin\DashboardController::class, 'storeTambahLaporan'])->name('kelola-laporan.store');
    Route::get('/kelola-laporan/edit', [\App\Http\Controllers\Admin\DashboardController::class, 'editLaporan'])->name('kelola-laporan.edit');
    Route::put('/kelola-laporan/edit', [\App\Http\Controllers\Admin\DashboardController::class, 'updateEditLaporan'])->name('kelola-laporan.edit.update');

    // Artikel Edukasi (Manajemen)


    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
