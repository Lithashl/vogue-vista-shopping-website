<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\UserOrderController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [FrontendController::class, 'index']);
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/collections', [FrontendController::class, 'categories']);
Route::get('/collections/{category_id}', [FrontendController::class, 'products']);
Route::get('/collections/{category_id}/{product_id}', [FrontendController::class, 'productView']);

Route::middleware(['auth'])->group(function(){
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::get('cart', [CartController::class, 'index']);
    Route::get('checkout', [CheckoutController::class, 'index']);
    Route::get('user/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('user/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::controller(SliderController::class)->group(function(){
        Route::get('sliders', [SliderController::class, 'index'])->name('slider.index');
        Route::get('sliders/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('sliders', [SliderController::class, 'store'])->name('slider.store');
        Route::get('sliders/{slider}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('sliders/{slider}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('sliders/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');    
    });    

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::put('settings', [SettingController::class, 'update'])->name('admin.settings.update');

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});
