<?php

use App\Http\Controllers\BettaFishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminPageController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


// -----------------------------
// ROUTE SEMENTARA UNTUK CLEAR CACHE
// -----------------------------
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return 'CLEAR BERHASIL COK!';
});

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// -----------------------------
// ADMIN ROUTES
// -----------------------------
Route::middleware(['auth', 'admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('fish', FishController::class);
    Route::delete('fish/{fish}/image', [FishController::class, 'deleteImage'])->name('fish.deleteImage');

    Route::resource('orders', OrderController::class);

    // Kelola user
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Admin page editor
    Route::get('/admin/pages/home/edit', [AdminPageController::class, 'editHome'])->name('admin.pages.home.edit');
    Route::post('/admin/pages/home', [AdminPageController::class, 'updateHome'])->name('admin.pages.home.update');
});

// -----------------------------
// USER ROUTES (HARUS LOGIN)
// -----------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// -----------------------------
// AUTH ROUTES
// -----------------------------
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';


