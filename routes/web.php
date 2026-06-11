<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\SppController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\TagihanController;
use App\Http\Controllers\Siswa\RiwayatController;

// Halaman utama redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (middleware auth dan role admin/bendahara)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Siswa
    Route::resource('siswa', SiswaController::class);
    
    // Manajemen Kelas
    Route::resource('kelas', KelasController::class);
    
    // Manajemen Jurusan
    Route::resource('jurusan', JurusanController::class)->except(['show']);
    
    // Manajemen SPP
    Route::resource('spp', SppController::class)->except(['show']);
    
    // Manajemen Pembayaran
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/siswa/{id}/tagihan', [PembayaranController::class, 'getTagihan'])->name('pembayaran.tagihan');
    
    // Verifikasi Pembayaran
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
    Route::post('/verifikasi/{id}/tolak', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'print'])->name('laporan.print');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    
    // Kelola Pengguna (hanya admin)
    Route::middleware(['admin'])->group(function () {
        Route::resource('pengguna', PenggunaController::class);
    });
});

// Siswa routes (middleware auth dan role siswa)
Route::middleware(['auth', 'siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');
    Route::put('/profil', [SiswaDashboardController::class, 'updateProfil'])->name('profil.update');
    
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan');
    Route::post('/tagihan/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');
    
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/download/{id}', [RiwayatController::class, 'downloadBukti'])->name('riwayat.download');
});

Route::get('/profil', [SiswaDashboardController::class, 'profil'])->name('profil');
Route::put('/profil', [SiswaDashboardController::class, 'updateProfil'])->name('profil.update');

// Di dalam group admin
Route::get('/tagihan/bulk', [App\Http\Controllers\Admin\BulkTagihanController::class, 'index'])->name('tagihan.bulk');
Route::post('/tagihan/bulk', [App\Http\Controllers\Admin\BulkTagihanController::class, 'generate'])->name('tagihan.bulk.generate');