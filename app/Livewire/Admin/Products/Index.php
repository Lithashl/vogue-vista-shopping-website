<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $productToDelete;

    public function deleteProduct($product_id)
    {
        $this->productToDelete = $product_id;
    }

    public function destroyProduct()
    {
        $product = Product::find($this->productToDelete);
        if ($product) {
            $path = 'public/uploads/products/' . $product->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $product->delete();
            session()->flash('message', 'Product Deleted');
            $this->dispatchBrowserEvent('close-modal');
        }
    }

    public function render()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.products.index', ['products' => $products]);
    }
}
