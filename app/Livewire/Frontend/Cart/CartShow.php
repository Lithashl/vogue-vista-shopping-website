<?php

namespace App\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $totalPrice = 0;


    public function decrementQuantity(int $cardId)
    {
        $cartData = Cart::where('id', $cardId)
                        ->where('user_id', auth()->user()->id)
                        ->first();

        if ($cartData && $cartData->quantity > 1) {
            $cartData->decrement('quantity');
            session()->flash('message', 'Quantity Updated');
        } else {
            session()->flash('message', 'Something Went Wrong!');
        }
    }

    public function incrementQuantity(int $cardId)
    {
        $cartData = Cart::where('id', $cardId)
                        ->where('user_id', auth()->user()->id)
                        ->first();

        if ($cartData && $cartData->quantity < $cartData->product->quantity) {
            $cartData->increment('quantity');
            session()->flash('message', 'Quantity Updated');
        } else {
            session()->flash('message', 'Something Went Wrong!');
        }
    }

    public function render()
    {
        $this->cart = Cart::with('product')->where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show', [
            'cart' => $this->cart,
        ]);
    }

    public function removeCartItem(int $cartItemId)
    {
        $cartItem = Cart::where('user_id', auth()->user()->id)
                        ->where('id', $cartItemId)
                        ->first();

        if ($cartItem) {
            $cartItem->delete();
            session()->flash('message', 'Cart item removed successfully');
        }
    }
}

