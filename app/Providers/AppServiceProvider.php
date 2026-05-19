<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.inc.frontend.navbar', function ($view) {
            $navCategories = Category::orderBy('name')->get();

            $cartCount     = 0;
            $wishlistCount = 0;

            if (auth()->check()) {
                $cartCount     = Cart::where('user_id', auth()->id())->sum('quantity');
                $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
            }

            $view->with(compact('navCategories', 'cartCount', 'wishlistCount'));
        });
    }
}
