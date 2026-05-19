<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; 
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();

        $product = new Product();
        $product->fill($validatedData);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
    
        $product->save();
    
        return redirect('admin/products')->with('message', 'Product added successfully');
    }    

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        return view('admin.products.edit', compact('product', 'categories'));
    }
    

    public function update(ProductFormRequest $request, $id)
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($id);
        $product->fill($validatedData);

        if ($request->hasFile('image')) {
            $path = public_path('uploads/products/' . $product->image);
            if (File::exists($path)) {
                File::delete($path);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect('admin/products')->with('message', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $imagePath = public_path('uploads/products/' . $product->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();

        return redirect('admin/products')->with('message', 'Product deleted successfully');
    }
}
