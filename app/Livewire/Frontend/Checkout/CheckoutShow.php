<?php

namespace App\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckoutShow extends Component
{
    public $totalProductAmount = 0;

    public $fullname, $email, $phone, $pincode, $address, $payment_mode = null, $payment_id = null;

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:121',
            'email'    => 'required|email|max:121',
            'phone'    => 'required|string|max:11|min:10',
            'pincode'  => 'required|digits:6',
            'address'  => 'required|string|max:500',
        ];
    }

    public function mount()
    {
        $this->fullname = auth()->user()->name;
        $this->email    = auth()->user()->email;

        $this->calculateTotalProductAmount();
    }

    public function placeOrder()
    {
        $this->validate();

        $cartItems = Cart::with('product')->where('user_id', auth()->user()->id)->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return false;
        }

        // Verify stock availability before proceeding
        foreach ($cartItems as $cartItem) {
            $product = Product::lockForUpdate()->find($cartItem->product_id);
            if (!$product || $product->quantity < $cartItem->quantity) {
                session()->flash('error', 'Sorry, "' . ($product->product_name ?? 'a product') . '" is out of stock or has insufficient quantity.');
                return false;
            }
        }

        DB::transaction(function () use ($cartItems) {
            $order = Order::create([
                'user_id'        => auth()->user()->id,
                'tracking_no'    => 'voguevista-' . Str::random(10),
                'fullname'       => $this->fullname,
                'email'          => $this->email,
                'phone'          => $this->phone,
                'pincode'        => $this->pincode,
                'address'        => $this->address,
                'status_message' => 'in progress',
                'payment_mode'   => $this->payment_mode,
                'payment_id'     => $this->payment_id,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price,
                ]);

                // Reduce product stock
                Product::where('id', $cartItem->product_id)
                    ->decrement('quantity', $cartItem->quantity);
            }

            Cart::where('user_id', auth()->user()->id)->delete();
            $this->totalProductAmount = 0;
        });

        return true;
    }

    public function codOrder()
    {
        $this->payment_mode = 'Cash on Delivery';

        if ($this->placeOrder()) {
            session()->flash('message', 'Order placed successfully! We will process it shortly.');
        }
    }

    public function qrisOrder()
    {
        $this->payment_mode = 'QRIS';

        $cartItems = Cart::with('product')->where('user_id', auth()->user()->id)->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        foreach ($cartItems as $cartItem) {
            $product = Product::lockForUpdate()->find($cartItem->product_id);
            if (!$product || $product->quantity < $cartItem->quantity) {
                session()->flash('error', 'Sorry, "' . ($product->product_name ?? 'a product') . '" is out of stock or has insufficient quantity.');
                return;
            }
        }

        $this->validate();

        DB::transaction(function () use ($cartItems) {
            $order = Order::create([
                'user_id'        => auth()->user()->id,
                'tracking_no'    => 'voguevista-' . Str::random(10),
                'fullname'       => $this->fullname,
                'email'          => $this->email,
                'phone'          => $this->phone,
                'pincode'        => $this->pincode,
                'address'        => $this->address,
                'status_message' => 'pending payment verification',
                'payment_mode'   => 'QRIS',
                'payment_id'     => null,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price,
                ]);

                Product::where('id', $cartItem->product_id)
                    ->decrement('quantity', $cartItem->quantity);
            }

            Cart::where('user_id', auth()->user()->id)->delete();
            $this->totalProductAmount = 0;
        });

        session()->flash('message', 'Order placed! Please complete your QRIS payment. We will verify and process it shortly.');
    }

    public function calculateTotalProductAmount()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->user()->id)->get();

        $this->totalProductAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });
    }

    public function render()
    {
        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount,
        ]);
    }
}
