<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserCabinetController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/catalog', [CatalogController::class, 'categories'])->name('catalog.categories');
Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');

// Пользовательский кабинет
Route::middleware('auth')->group(function () {
    Route::get('/cabinet', [UserCabinetController::class, 'index'])->name('cabinet');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});

// Админ-панель
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/buy', [AdminController::class, 'buyProduct'])->name('admin.users.buy');
    Route::post('/users/{user}/buy', [AdminController::class, 'storePurchase'])->name('admin.users.storePurchase');
    Route::get('/users/{user}/orders', [AdminController::class, 'userOrders'])->name('admin.users.orders');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name(name: 'admin.orders');
    Route::get('/orders/{order}/edit', [AdminController::class, 'editOrder'])->name(name: 'admin.orders.edit');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name(name: 'admin.orders.update');
    Route::delete('/admin/orders/{order}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');

    Route::get('/discounts', [AdminController::class, 'discounts'])->name('admin.discounts');
    Route::post('/discounts', [AdminController::class, 'storeDiscount'])->name('admin.discounts.store');
    Route::get('/discounts/{discountTier}/edit', [AdminController::class, 'editDiscount'])->name('admin.discounts.edit');
    Route::put('/discounts/{discountTier}', [AdminController::class, 'updateDiscount'])->name('admin.discounts.update');
    Route::delete('/discounts/{discountTier}', [AdminController::class, 'deleteDiscount'])->name('admin.discounts.delete');

});

Auth::routes();
