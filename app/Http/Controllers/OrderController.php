<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAttribute;
use App\Models\OrderItem;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function save(Request $request)
    {
       $user = auth()->user();

        // Ensure payment method is selected
        $request->validate([
            'payment_method' => 'required|in:cod,bank,card',
        ]);

        // Load cart with attributes
        $cartItems = Cart::with(['stock.product', 'stock.attributes.attribute', 'stock.attributes.attributeValue'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->stock->selling_price);
        $shipping_cost = $user->defaultAddress->area->shipping_cost;
        $total = $subtotal + $shipping_cost;

        DB::beginTransaction();

        try {

            $pendingStatus = Status::whereTranslation('name', 'Pending', 'en')->first();

            // Create Order
            $order = Order::create([
                'user_id'        => $user->id,
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'email'          => $request->email,
                'order_number'   => 'ORD-' . time(),
                'status_id'      => $pendingStatus->id,
                'vat_rate'       => 0,
                'vat'            => 0,
                'sub_total'       => $subtotal,
                'shipping_cost'  => $shipping_cost,
                'discount'       => 0,
                'total'          => $total,
                'payment_method' => $request->payment_method,
            ]);

            $user->defaultAddress()->update($request->except('first_name', 'last_name', 'email', 'payment_method', '_token'));

            $order->address()->create([
                'address_id' => $user->defaultAddress->id
            ]);

            // Create items + attributes
            foreach ($cartItems as $item) {

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'stock_id' => $item->stock_id,
                    'qty'      => $item->quantity,
                    'price'    => $item->stock->selling_price,
                    'vat_rate' => 0,
                    'vat'      => 0,
                    'discount' => 0,
                    'sub_total' => $item->quantity * $item->stock->selling_price,
                ]);

                // Snapshot attributes
                foreach ($item->stock->attributes as $attr) {
                    OrderAttribute::create([
                        'order_item_id' => $orderItem->id,
                        'name'          => $attr->attribute->name,
                        'value'         => $attr->attributeValue->name,
                    ]);
                }
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors(['Error: ' . $e->getMessage()]);
        }

        }
}
