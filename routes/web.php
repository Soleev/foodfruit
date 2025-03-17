<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/contacts', function () {
    return view('pages.contacts', ['title' => 'page title']);
});

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/about', function () {
    return view('pages.about', ['title' => 'page title']);
});
Route::get('/catalog', function () {
    return view('pages.catalog');
});
Route::get('/catalog/{slug}', [ProductController::class, 'showByCategorySlug'])->name('catalog.pages');
Route::get('/catalog/{category_slug}', [ProductController::class, 'showByCategorySlug'])->name('products.category');
Route::get('/catalog/{category_slug}/{product_slug}', [ProductController::class, 'showProduct'])->name('products.show');

Route::post('/save-callback', [CallbackController::class, 'store'])->name('save.callback');
