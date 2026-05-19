<?php

namespace App\Livewire\Frontend\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class Index extends Component
{
    public $products, $category, $priceInput = '';

    protected $queryString = [
        'priceInput' => ['except' => '', 'as' => 'price'],
    ];

    public function mount($category_id)
    {
        $this->category = Category::find($category_id);
        
        if ($this->category) {
            $this->products = Product::where('category_id', $this->category->id)->get();
        } else {
            session()->flash('error', 'Category not found.');
            $this->products = [];
        }
    }

    public function render()
    {
        $products = Product::where('category_id', $this->category->id);
    
        if ($this->priceInput === 'high-to-low') {
            $products->orderBy('price', 'DESC');
        } elseif ($this->priceInput === 'low-to-high') {
            $products->orderBy('price', 'ASC');
        }
    
        $this->products = $products->get();
    
        return view('livewire.frontend.products.index');
    }    
}

