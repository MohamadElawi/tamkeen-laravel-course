<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Web\UserProductController;
use App\Http\Controllers\User\Web\UserOrderController;

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\web\CartItemsController;

Route::get('/', function () {
    return view('welcome');
});




// Route::resource('products', ProductController::class);   

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Product Routes
    Route::get('/products', [UserProductController::class, 'index'])->name('user.products.index');
    Route::get('/products/{id}', [UserProductController::class, 'show'])->name('user.products.show');

    // User Order Routes
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/checkout', [UserOrderController::class, 'create'])->name('user.orders.create');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('user.orders.store');
    Route::get('/orders/{id}', [UserOrderController::class, 'show'])->name('user.orders.show');

    // User Cart Routes
    Route::post('/cart-items', [CartItemsController::class, 'store'])->name('user.cart-items.store');
});

// Admin Routes
Route::middleware(['auth:admin-web'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // Admin Product Management
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');


 Route::middleware(['auth'])->prefix('manage')->name('manage.')->group(function () {
        Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins');
        Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}', [AdminManagementController::class, 'show'])->name('admins.show');
        Route::get('/admins/{admin}/edit', [AdminManagementController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [AdminManagementController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');
        Route::post('/admins/{admin}/toggle-status', [AdminManagementController::class, 'toggleStatus'])
            ->name('admins.toggle-status');
    });


    // Admin Category Management (placeholder routes)
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('admin.categories.index');

    // Admin Color Management (placeholder routes)
    Route::get('/colors', function () {
        return view('admin.colors.index');
    })->name('admin.colors.index');

    // Admin Order Management (placeholder routes)
    Route::get('/web/orders', function () {
        return view('admin.orders.index');
    })->name('admin.orders.index');

    // Admin Customer Management (placeholder routes)
    Route::get('/customers', function () {
        return view('admin.customers.index');
    })->name('admin.customers.index');

    // Admin Management (placeholder routes)
    Route::get('/manage', function () {
        return view('admin.manage.index');
    })->name('admin.manage.index');
});

// Include Auth Routes
require __DIR__.'/auth.php';


