<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'course'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }
}
