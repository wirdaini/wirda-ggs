<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MultipleuploadsController;
use App\Http\Controllers\AuthController;

// ============ PUBLIC ROUTES ============
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');

// ============ AUTH ROUTES (TANPA MIDDLEWARE) ============
Route::get('auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// ============ PROTECTED ROUTES (DENGAN MIDDLEWARE checkislogin) ============
// SESUAI CONTOH DOSEN: menggunakan Route::group
Route::group(['middleware' => ['checkislogin']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pelanggan', PelangganController::class);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');

    Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])->name('uploads');
    Route::post('/save', [MultipleuploadsController::class, 'store'])->name('uploads.store');
    Route::delete('/multipleuploads/{id}', [MultipleuploadsController::class, 'destroy'])->name('uploads.destroy');

});

// ============ ROUTES DENGAN MULTIPLE MIDDLEWARE ============
// Route user butuh checkislogin DAN checkrole:Super Admin
Route::group(['middleware' => ['checkislogin', 'checkrole:Super Admin']], function () {
    Route::resource('user', UserController::class);
});
