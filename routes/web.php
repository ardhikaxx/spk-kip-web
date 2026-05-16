<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\BobotController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PrometheeController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaprodiController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('mahasiswa/template', [MahasiswaController::class, 'template'])->name('mahasiswa.template');
    Route::post('mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::resource('mahasiswa', MahasiswaController::class)->except(['create', 'show', 'edit']);

    Route::resource('kriteria', KriteriaController::class)
        ->parameters(['kriteria' => 'kriterium'])
        ->except(['create', 'show', 'edit']);

    Route::resource('sub-kriteria', SubKriteriaController::class)
        ->parameters(['sub-kriteria' => 'sub_kriterium'])
        ->only(['index', 'edit', 'update']);

    Route::get('bobot', [BobotController::class, 'index'])->name('bobot.index');
    Route::post('bobot', [BobotController::class, 'store'])->name('bobot.store');

    Route::get('alternatif/mahasiswa/{nim}', [AlternatifController::class, 'getMahasiswaDetail'])->name('alternatif.mahasiswa');
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
