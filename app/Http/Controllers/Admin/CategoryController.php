<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10); 
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/category'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect('admin/category')->with('message', 'Category Added Successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryFormRequest $request, Category $category)
    {
        $validatedData = $request->validated();

        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $path = public_path('uploads/category/' . $category->image);
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;

            $file->move('uploads/category/', $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect('admin/category')->with('message', 'Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        // Check if there are any products associated with this category
        $associatedProducts = Product::where('category_id', $category->id)->exists();
    
        // If there are associated products, prevent deletion
        if ($associatedProducts) {
            return redirect('admin/category')->with('error', 'Cannot delete. There are products associated with this category.');
        }
    
        // If no associated products, proceed with deletion
        $imagePath = public_path('uploads/category/' . $category->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
    
        $category->delete();
    
        return redirect('admin/category')->with('message', 'Category Deleted Successfully');
    }
}
