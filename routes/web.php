<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerKosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OwnerKosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - PUSATKOS
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', function () {
    return view('contact.index');
})->name('contact');
Route::get('/artikel', function () {
    return view('artikel.index');
})->name('artikel');

Route::get('/promo', function () {
    return view('promo.index');
})->name('promo');

// Pencarian Kos Umum
Route::get('/search', function () {
    return redirect('/kos');
})->name('search.kos');
Route::get('/kos', [KosController::class, 'index'])->name('kos.index');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Kos Publik
Route::prefix('kos')->name('kos.')->group(function () {
    Route::get('/{slug}', [KosController::class, 'show'])->name('show');
});

// Area Owner
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/', [OwnerKosController::class, 'dashboard'])->name('dashboard');

    Route::prefix('kos')->name('kos.')->group(function () {
        Route::get('/', [OwnerKosController::class, 'index'])->name('index');
        Route::get('/my', [OwnerKosController::class, 'myKos'])->name('my');
        Route::get('/manage', [OwnerKosController::class, 'manage'])->name('manage');
        Route::get('/create', [OwnerKosController::class, 'create'])->name('create');
        Route::post('/store', [OwnerKosController::class, 'store'])->name('store');
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

// Area Member
Route::prefix('member')->name('member.')->group(function () {
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [MemberController::class, 'invoice'])->name('index');
        Route::get('/{nomor_invoice}', [MemberController::class, 'invoiceDetail'])->name('show');
    });
});
