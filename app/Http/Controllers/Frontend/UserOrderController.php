<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }
}
