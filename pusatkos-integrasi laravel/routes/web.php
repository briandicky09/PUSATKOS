<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerKosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerKosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PUSATKOS
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Area Owner
Route::prefix('owner')->name('owner.')->group(function () {
    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [OwnerKosController::class, 'index'])->name('index');
        Route::get('/create', [OwnerKosController::class, 'create'])->name('create');
        Route::get('/{slug}', [OwnerKosController::class, 'show'])->name('show');
    });
});

// Area Customer
Route::prefix('customer')->name('customer.')->group(function () {
    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [CustomerKosController::class, 'index'])->name('index');
    });

    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [CustomerKosController::class, 'invoice'])->name('index');
    });
});
