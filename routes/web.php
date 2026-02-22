<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserShipController as AdminUserShipController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.orders.index');
    }
    return redirect()->route('ships.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ships
    Route::resource('ships', ShipController::class)->except(['show']);

    // Orders
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
});

// Admin routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('vendors', VendorController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status/{status}', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('orders/{order}/invoice', [AdminOrderController::class, 'downloadInvoice'])->name('orders.invoice');

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('admins', [AdminUserController::class, 'indexAdmins'])->name('admins.index');
    Route::get('admins/create', [AdminUserController::class, 'createAdmin'])->name('admins.create');
    Route::post('admins', [AdminUserController::class, 'storeAdmin'])->name('admins.store');
    Route::get('admins/{user}', [AdminUserController::class, 'showAdmin'])->name('admins.show');
    Route::delete('admins/{user}', [AdminUserController::class, 'destroyAdmin'])->name('admins.destroy');
    Route::get('users/{user}/ships/create', [AdminUserShipController::class, 'create'])->name('users.ships.create');
    Route::post('users/{user}/ships', [AdminUserShipController::class, 'store'])->name('users.ships.store');
});

require __DIR__.'/auth.php';
