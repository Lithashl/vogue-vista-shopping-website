<?php

namespace App\Livewire\Frontend\Products;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;

class View extends Component
{
    public $category, $product, $quantityCount = 1;

    public function addToWishlist($productId)
    {
        if(Auth::check()){

            if(Wishlist::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists()){
                
                session()->flash('message','Already added to wishlist');
                return false;
            }
            else{

                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                session()->flash('message','Wishlist Added successfully');
            }
        }else{
                session()->flash('message','Please Login to continue');
                return false;
        }
    }

    public function incrementQuantity(){

        if($this->quantityCount < 10){
        $this->quantityCount++;
        }
    }

    public function decrementQuantity(){

        if($this->quantityCount > 1){
        $this->quantityCount--;
        }
    }

    public function addToCart(int $productId)
    {
        if (Auth::check()) {
            $product = Product::find($productId); 
    
            if ($product) {
                if ($product->quantity > 0) {
                    if ($this->quantityCount <= $product->quantity) {

                        $existingCartItem = Cart::where('user_id', auth()->user()->id)
                                                ->where('product_id', $productId)
                                                ->first();

                        if ($existingCartItem) {
                            session()->flash('message', 'Already added to Cart');
                        } else {
                            Cart::create([
                                'user_id' => auth()->user()->id,
                                'product_id' => $productId,
                                'quantity' => $this->quantityCount
                            ]);
                            session()->flash('message', 'Product Added to Cart');
                        }
                    } else {
                        session()->flash('message', 'Quantity exceeds available stock');
                    }
                } else {
                    session()->flash('message', 'Out of Stock');
                }
            } else {
                session()->flash('message', 'Product not found');
            }
        } else {
            session()->flash('message', 'Please Login to add to cart');
        }
    }
    
    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.products.view',[
            'category' => $this->category,
            'product' => $this->product,
        ]);
    }
}
