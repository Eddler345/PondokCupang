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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD ikan
        Route::resource('fish', FishController::class);
        Route::delete('fish/{fish}/image', [FishController::class, 'deleteImage'])->name('fish.deleteImage');

        // Manage orders
        Route::resource('orders', OrderController::class);

        // Manage users
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Admin page editor
        Route::get('/admin/pages/home/edit', [AdminPageController::class, 'editHome'])->name('admin.pages.home.edit');
        Route::post('/admin/pages/home', [AdminPageController::class, 'updateHome'])->name('admin.pages.home.update');
    });


Route::middleware(['auth'])->group(function () {

    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // User orders
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
