<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

// Public home page - shows menu without login required
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('home');

// QR Code menu for specific table
Route::get('/menu/{table?}', [App\Http\Controllers\FrontController::class, 'menu'])->name('menu.qr');

/*
|--------------------------------------------------------------------------
| Customer Routes (Authenticated Customers)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Customer home page (after login)
    Route::get('/home', [App\Http\Controllers\FrontController::class, 'index'])->name('Frontend.home');
    
    // Customer can place orders
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('Admin.dashboard');
    })->name('admin.dashboard');

    // Resource management
    Route::resource('users', UserController::class)->names('users')->except('show');
    Route::resource('categories', CategoryController::class)->names('categories')->except('show');
    Route::resource('sub-categories', SubCategoryController::class)->names('sub-categories');
    Route::resource('foods', FoodController::class)->names('foods')->except('show');
    Route::resource('tables', TableController::class)->names('tables')->except('show');
    Route::resource('reservations', ReservationController::class)->names('reservations')->except('show');

    // Admin can view and manage all orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
});

/*
|--------------------------------------------------------------------------
| Chef Routes (Chef Only)
|--------------------------------------------------------------------------
*/

Route::prefix('chef')->middleware(['auth', 'role:chef'])->group(function () {
    // Chef Dashboard
    Route::get('/dashboard', [ChefController::class, 'dashboard'])->name('chef.dashboard');
    
    // Food Management
    Route::get('/foods/create', [ChefController::class, 'createFood'])->name('chef.foods.create');
    Route::post('/foods', [ChefController::class, 'storeFood'])->name('chef.foods.store');
    
    // Orders - Chef can view and update status (preparing/ready)
    Route::get('/orders', [ChefController::class, 'orders'])->name('chef.orders');
    Route::patch('/orders/{id}', [ChefController::class, 'updateOrder'])->name('chef.orders.update');
    
    // Read-only views
    Route::get('/menu', [ChefController::class, 'menu'])->name('chef.menu');
    Route::get('/tables', [ChefController::class, 'tables'])->name('chef.tables');
});

/*
|--------------------------------------------------------------------------
| Waiter Routes (Waiter Only)
|--------------------------------------------------------------------------
*/

Route::prefix('waiter')->middleware(['auth', 'role:waiter'])->group(function () {
    // Waiter Dashboard
    Route::get('/dashboard', [WaiterController::class, 'dashboard'])->name('waiter.dashboard');
    
    // Orders - Waiter can view and mark as delivered
    Route::get('/orders', [WaiterController::class, 'orders'])->name('waiter.orders');
    Route::patch('/orders/{id}', [WaiterController::class, 'updateOrder'])->name('waiter.orders.update');
    
    // Tables
    Route::get('/tables', [WaiterController::class, 'tables'])->name('waiter.tables');
    
    // Take order
    Route::get('/take-order/{table?}', [WaiterController::class, 'takeOrder'])->name('waiter.take-order');
    Route::post('/store-order', [WaiterController::class, 'storeOrder'])->name('waiter.store-order');
});

/*
|--------------------------------------------------------------------------
| Profile Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
