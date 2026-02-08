<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view_order'])->only(['index', 'show', 'invoice']);
    }

    public function index()
    {
        $orders = Order::all();

        return view('admin.orders.index', compact('orders'));
    }
    public function show(Order $order)
    {

        $order->load([
            'items.stock.product.tax',
            'items.attributes',
            'address.address.area.parent.parent', // area -> governorate -> country
            'status'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {

        $order->load([
            'items.stock.product.tax',
            'items.attributes',
            'address.address.area.parent.parent', // area -> governorate -> country
            'status'
        ]);

        return view('site.orders.invoice', compact('order'));
    }
}
