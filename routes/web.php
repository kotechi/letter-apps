<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\WordController;

Route::get('/', function () {return view('auth.login');} )->name('/');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::put('/settings/{id}', [AdminController::class, 'update'])->name('admin.update');

    Route::post('/export-word-pindah', [WordController::class, 'export'])->name('export.word.pindah');


    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/user', [UserController::class, 'index'])->name('admin.users');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/user', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');


    Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    Route::get('/surat', [\App\Http\Controllers\Admin\SuratController::class, 'index'])->name('admin.surats');
    Route::get('/surat/{surat}', [\App\Http\Controllers\Admin\SuratController::class, 'show'])->name('admin.surats.show');
    Route::delete('/surat/{surat}', [\App\Http\Controllers\Admin\SuratController::class, 'destroy'])->name('admin.surats.destroy');
    Route::delete('/surat', [\App\Http\Controllers\Admin\SuratController::class, 'destroyall'])->name('admin.surats.destroyall');
    Route::get('/surat/{surat}/edit', [\App\Http\Controllers\Admin\SuratController::class, 'edit'])->name('admin.surats.edit');
    Route::put('/surat/{surat}', [\App\Http\Controllers\Admin\SuratController::class, 'update'])->name('admin.surats.update');
    Route::post('/surat/export', [\App\Http\Controllers\Admin\SuratController::class, 'export'])->name('admin.surats.export');
    Route::get('/surat/{surat}/download/{type}', [\App\Http\Controllers\Admin\SuratController::class, 'download'])->name('admin.surats.download');

    Route::get('/ijasah', [\App\Http\Controllers\Admin\IjasahController::class, 'index'])->name('admin.ijasah.index');
    Route::get('/ijasah/create', [\App\Http\Controllers\Admin\IjasahController::class, 'create'])->name('admin.ijasah.create');
    Route::post('/ijasah', [\App\Http\Controllers\Admin\IjasahController::class, 'store'])->name('admin.ijasah.store');
    Route::get('/ijasah/{ijasah}/edit', [\App\Http\Controllers\Admin\IjasahController::class, 'edit'])->name('admin.ijasah.edit');
    Route::put('/ijasah/{ijasah}', [\App\Http\Controllers\Admin\IjasahController::class, 'update'])->name('admin.ijasah.update');
    Route::delete('/ijasah/{ijasah}', [\App\Http\Controllers\Admin\IjasahController::class, 'destroy'])->name('admin.ijasah.destroy');
    Route::get('/ijasah/{ijasah}', [\App\Http\Controllers\Admin\IjasahController::class, 'show'])->name('admin.ijasah.show');

    Route::get('/school', [SchoolController::class, 'index'])->name('admin.school');
    Route::get('/school/create', [SchoolController::class, 'create'])->name('admin.school.create');
    Route::post('/school', [SchoolController::class, 'store'])->name('admin.school.store');
    Route::get('/school/{school}/edit', [SchoolController::class, 'edit'])->name('admin.school.edit');
    Route::put('/school/{school}', [SchoolController::class, 'update'])->name('admin.school.update');
    Route::delete('/school/{school}', [SchoolController::class, 'destroy'])->name('admin.school.destroy');    
    Route::get('/settings',[AdminController::class, 'setting'])->name('admin.settings');

    // Surat Masuk Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('surat-masuk', \App\Http\Controllers\Admin\SuratMasukController::class);
        Route::get('surat-masuk/{suratMasuk}/export', [\App\Http\Controllers\Admin\SuratMasukController::class, 'exportWord'])->name('surat-masuk.export');
        Route::get('surat-masuk/{suratMasuk}/download/{type}', [\App\Http\Controllers\Admin\SuratMasukController::class, 'download'])->name('surat-masuk.download');
    });
});

