<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('products', ProductController::class);

// User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth:admin-web'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // Admin Product Management Routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])
        ->name('admin.products.toggle-status');

    // Admin Product Management Routes
    Route::get('/manage/admins', [AdminManagementController::class, 'index'])->name('admin.manage.index');
    Route::get('/manage/admins/create', [AdminManagementController::class, 'create'])->name('admin.manage.create');
    Route::post('/manage/admins', [AdminManagementController::class, 'store'])->name('admin.manage.store');
    Route::get('/manage/admins/{admin}', [AdminManagementController::class, 'show'])->name('admin.manage.show');
    Route::get('/manage/admins/{admin}/edit', [AdminManagementController::class, 'edit'])->name('admin.manage.edit');
    Route::put('/manage/admins/{admin}', [AdminManagementController::class, 'update'])->name('admin.manage.update');
    Route::delete('/manage/admins/{admin}', [AdminManagementController::class, 'destroy'])->name('admin.manage.destroy');
    Route::post('/manage/admins/{admin}/toggle-status', [AdminManagementController::class, 'toggleStatus'])
        ->name('admin.products.toggle-status');
});



// Include Auth Routes
require __DIR__.'/auth.php';


