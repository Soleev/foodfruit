<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


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
