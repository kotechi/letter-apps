<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\WordController;

Route::get('/', function () {return view('welcome');} )->name('/');

Route::middleware(['auth', 'admin'])->group(function () {

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


    Route::get('/school', [SchoolController::class, 'index'])->name('admin.school');
    Route::get('/school/create', [SchoolController::class, 'create'])->name('admin.school.create');
    Route::post('/school', [SchoolController::class, 'store'])->name('admin.school.store');
    Route::get('/school/{school}/edit', [SchoolController::class, 'edit'])->name('admin.school.edit');
    Route::put('/school/{school}', [SchoolController::class, 'update'])->name('admin.school.update');
    Route::delete('/school/{school}', [SchoolController::class, 'destroy'])->name('admin.school.destroy');    
    Route::get('/settings',[AdminController::class, 'setting'])->name('admin.settings');
});

