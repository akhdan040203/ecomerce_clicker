<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with(['user', 'payment'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = \App\Models\Order::with(['user', 'payment', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
