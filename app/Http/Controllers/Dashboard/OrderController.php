<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->paginate(5);
        return view('home', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load( 'orderItems', 'orderItems.product');
        return view('showOrder', compact('order'));
    }
}
