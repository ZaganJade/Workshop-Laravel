<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OtpHandlerController;
use App\Http\Controllers\Auth\OauthGoogleHandlerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\Chatbot\ChatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

// Chatbot Route
Route::post('/chatbot/chat', [ChatController::class, 'chat'])->name('chatbot.chat');

// POS & Midtrans Routes
Route::get('/pos', [PaymentController::class, 'index'])->name('pos');
Route::get('/menus/{idvendor}', [PaymentController::class, 'getMenusByVendor']);
Route::post('/order', [PaymentController::class, 'createOrder']);
Route::get('/snap-token/{id}', [PaymentController::class, 'getSnapToken']);
Route::get('/payment/success/{id}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Auth::routes();

// Manual Auth Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Auth Routes
Route::get('/auth/google', [OauthGoogleHandlerController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/switch', [OauthGoogleHandlerController::class, 'switchAccount'])->name('auth.google.switch');
Route::get('/auth/google/callback', [OauthGoogleHandlerController::class, 'handleGoogleCallback']);

// OTP Routes
Route::get('/auth/otp', [OtpHandlerController::class, 'showOtpForm'])->name('auth.otp.form');
Route::post('/auth/otp', [OtpHandlerController::class, 'verifyOtp'])->name('auth.otp.verify');
Route::post('/auth/otp/resend', [OtpHandlerController::class, 'resendOtp'])->name('auth.otp.resend');

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

    Route::post('/admin/buku/pdf', [BukuController::class, 'generatePdf'])->name('admin.buku.pdf');

    Route::resource('/admin/buku', BukuController::class)->names([
        'index' => 'admin.buku.index',
        'create' => 'admin.buku.create',
        'store' => 'admin.buku.store',
        'edit' => 'admin.buku.edit',
        'update' => 'admin.buku.update',
        'destroy' => 'admin.buku.destroy',
    ]);

    // Barang Print Label Routes
    Route::get('/admin/barang', [PrintController::class, 'index'])->name('admin.barang.index');
    Route::post('/admin/print-label', [PrintController::class, 'print'])->name('admin.print-label');

    // Wilayah (Blade + jQuery only, no database)
    Route::get('/admin/wilayah', function () {
        return view('admin.wilayah.wilayah');
    })->name('admin.wilayah');

    // Tambah Barang (Blade + jQuery only, no database)
    Route::get('/admin/tambah-barang/html', function () {
        return view('admin.tambah-barang.tambah_barang-index');
    })->name('admin.tambah-barang.html');

    Route::get('/admin/tambah-barang/datatables', function () {
        return view('admin.tambah-barang.index-datatables');
    })->name('admin.tambah-barang.datatables');
});
