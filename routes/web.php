<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

// Manual Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['check.login'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('admin.logs.index');
    
    Route::resource('/admin/kategori', KategoriController::class)->names([
        'index' => 'admin.kategori.index',
        'create' => 'admin.kategori.create',
        'store' => 'admin.kategori.store',
        'edit' => 'admin.kategori.edit',
        'update' => 'admin.kategori.update',
        'destroy' => 'admin.kategori.destroy',
    ]);

    Route::resource('/admin/buku', BukuController::class)->names([
        'index' => 'admin.buku.index',
        'create' => 'admin.buku.create',
        'store' => 'admin.buku.store',
        'edit' => 'admin.buku.edit',
        'update' => 'admin.buku.update',
        'destroy' => 'admin.buku.destroy',
    ]);
});
