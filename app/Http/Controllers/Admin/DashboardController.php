<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Slider;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalProducts  = Product::count();
        $totalCategories = Category::count();
        $totalOrders    = Order::count();
        $totalSliders   = Slider::count();
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCategories', 'totalOrders', 'totalSliders', 'recentProducts'
        ));
    }
}
