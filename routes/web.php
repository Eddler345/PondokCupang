<?php

use App\Http\Controllers\BettaFishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\DashboardController;




use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    // Rute yang HANYA BOLEH DIAKSES ADMIN
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('fish', FishController::class);
    Route::delete('fish/{fish}/image', [FishController::class, 'deleteImage'])->name('fish.deleteImage');
    Route::resource('orders', OrderController::class);
    
    // Route untuk manajemen user
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Admin page editor
    Route::get('/admin/pages/home/edit', [\App\Http\Controllers\AdminPageController::class, 'editHome'])->name('admin.pages.home.edit');
    Route::post('/admin/pages/home', [\App\Http\Controllers\AdminPageController::class, 'updateHome'])->name('admin.pages.home.update');
});

Route::middleware(['auth'])->group(function () {
    // Rute yang BOLEH DIAKSES OLEH SEMUA USER YANG SUDAH LOGIN (termasuk Admin)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    
    // Routes untuk pemesanan user
    Route::get('/orders', [OrderController::class, 'userOrders'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});


Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


require __DIR__.'/auth.php';
