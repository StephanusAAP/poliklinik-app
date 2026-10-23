<?php


use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PoliController;
use App\Http\Controllers\Pasien\RiwayatPoliController;
use App\Http\Controllers\Pasien\PembayaranController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);

    Route::get('/admin/obat-export', [App\Http\Controllers\Admin\ObatController::class, 'export'])->name('obat.export');
    Route::get('/admin/dokter-export', [DokterController::class, 'export'])->name('dokter.export');
    Route::get('/admin/pasien-export', [PasienController::class, 'export'])->name('pasien.export');
    Route::get('/pembayaran', [\App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::post('/pembayaran/{id}/verify', [\App\Http\Controllers\Admin\PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
    Route::post('/pembayaran/{id}/verify', [\App\Http\Controllers\Admin\PembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
    Route::post('/pembayaran/{id}/reject', [\App\Http\Controllers\Admin\PembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
});


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');
    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');

    Route::get('/dokter/jadwal-export', [App\Http\Controllers\Dokter\JadwalPeriksaController::class, 'export'])->name('jadwal.export');
    Route::get('/riwayat-pasien-export', [App\Http\Controllers\Dokter\RiwayatPasienController::class, 'export'])->name('riwayat-pasien.export');
});


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/daftar', [PoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PoliController::class, 'submit'])->name('pasien.daftar.submit');
    Route::get('/riwayat', [RiwayatPoliController::class, 'index'])->name('pasien.riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatPoliController::class, 'show'])->name('pasien.riwayat.show');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pasien.tagihan.index');
    Route::post('/pembayaran/{id}', [PembayaranController::class, 'upload'])->name('pasien.pembayaran.upload');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect($notification->data['url']);
    })->name('notifications.read');
});
