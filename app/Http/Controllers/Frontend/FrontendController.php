<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Livewire\Frontend\Products\Index;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::latest()->take(8)->get();
        $products = Product::latest()->take(8)->get();
        return view('frontend.index', compact('sliders', 'categories', 'products'));
    }

    public function categories()
    {
        $categories = Category::all();
        return view('frontend.collections.category.index', compact('categories'));
    }

    public function products($category_id)
    {
        $category = Category::find($category_id);

        if ($category) {
            $products = $category->products;
            return view('frontend.collections.products.index', compact('products', 'category', 'category_id'));
        } else {
            return redirect()->back()->with('error', 'Category not found.');
        }
    }

    public function search(Request $request)
    {
        $query    = trim($request->input('q', ''));
        $products = collect();

        if ($query !== '') {
            $products = Product::with('category')
                ->where('product_name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->latest()
                ->paginate(12)
                ->withQueryString();
        }

        return view('frontend.search', compact('products', 'query'));
    }

    public function productView(string $category_id, string $product_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->back();
        }

        $product = Product::where('category_id', $category_id)->find($product_id);

        if (!$product) {
            return redirect()->back();
        }

        return view('frontend.collections.products.view', compact('product', 'category'));
    }
    
}
