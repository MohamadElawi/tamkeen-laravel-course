<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProductController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('products', ProductController::class);

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

    // Admin Category Management (placeholder routes)
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('admin.categories.index');

    // Admin Color Management (placeholder routes)
    Route::get('/colors', function () {
        return view('admin.colors.index');
    })->name('admin.colors.index');

    // Admin Order Management (placeholder routes)
    Route::get('/orders', function () {
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


