<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Wishlist;

class WishlistShow extends Component
{
    public $message = '';
    
    public function removeWishlistItem(int $wishlistId){
        Wishlist::where('user_id', auth()->user()->id)->where('id',$wishlistId)->delete();
        
        $this->message = 'Wishlist item removed successfully';
    }

    public function render()
    {
        $wishlist = Wishlist::with('product')->where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.wishlist-show',[
            'wishlist' => $wishlist
        ]);
    }
}
