<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
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
        $statuses = Status::all();

        return view('admin.orders.index', compact('orders', 'statuses'));
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


    public function updateStatus(Request $request)
    {
        // Validation
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Get Order
        $order = Order::findOrFail($request->id);

        // (اختياري احترافي) منع تغيير الحالة لو Delivered
        if ($order->status && $order->status->translate('en')->name === 'Delivered') {
            return response()->json([
                'status' => false,
                'message' => trans('order.cannot_change')
            ], 403);
        }

        // Update
        $order->status_id = $request->status_id;
        $order->save();

        // Reload relation عشان نجيب الاسم واللون
        $order->load('status');

        return response()->json([
            'status' => true,
            'status_name' => $order->status->name,
            'status_class' => $order->status->color ?? 'secondary'
        ]);
    }

}
