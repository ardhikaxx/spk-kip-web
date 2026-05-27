<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\BobotController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PrometheeController;
use App\Http\Controllers\Admin\KategorisasiKriteriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KaprodiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended(Auth::user()->role === 'admin' ? route('admin.dashboard') : route('kaprodi.dashboard'));
    }
    
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'verifyEmail'])->name('password.email');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('mahasiswa/template', [MahasiswaController::class, 'template'])->name('mahasiswa.template');
    Route::post('mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::delete('mahasiswa/deleteAll', [MahasiswaController::class, 'destroyAll'])->name('mahasiswa.destroyAll');
    Route::resource('mahasiswa', MahasiswaController::class)->except(['create', 'show', 'edit']);

    Route::resource('kriteria', KriteriaController::class)
        ->parameters(['kriteria' => 'kriterium'])
        ->except(['create', 'show', 'edit']);

    Route::resource('kategorisasi-kriteria', KategorisasiKriteriaController::class)
        ->parameters(['kategorisasi-kriteria' => 'kategorisasi_kriterium'])
        ->only(['index', 'edit', 'update']);

    Route::get('bobot', [BobotController::class, 'index'])->name('bobot.index');
    Route::post('bobot', [BobotController::class, 'store'])->name('bobot.store');

    Route::get('alternatif/mahasiswa/{nim}', [AlternatifController::class, 'getMahasiswaDetail'])->name('alternatif.mahasiswa');
    Route::post('alternatif/bulk', [AlternatifController::class, 'bulkStore'])->name('alternatif.bulk');
    Route::delete('alternatif/deleteAll', [AlternatifController::class, 'destroyAll'])->name('alternatif.destroyAll');
    Route::resource('alternatif', AlternatifController::class)->except(['create', 'show', 'edit', 'update']);

    Route::get('promethee', [PrometheeController::class, 'index'])->name('promethee.index');
    Route::post('promethee/hitung', [PrometheeController::class, 'hitung'])->name('promethee.hitung');

    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('hasil/pdf/{tahun}', [HasilController::class, 'downloadPdf'])->name('hasil.pdf');

    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
});

Route::prefix('kaprodi')->middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('/dashboard', [KaprodiController::class, 'index'])->name('kaprodi.dashboard');
    Route::get('/surat/{nim}', [KaprodiController::class, 'suratRekomendasi'])->name('kaprodi.surat');
    Route::get('/surat/{nim}/download', [KaprodiController::class, 'downloadSurat'])->name('kaprodi.surat.download');
});
