<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderAttribute;
use App\Models\OrderItem;
use App\Models\Status;
use App\Models\Stock;
use App\Models\StockAttribute;
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
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->stock->product->final_price;
        });
        $vat = $cartItems->sum(function ($item) {
            return $item->quantity * $item->stock->product->tax_amount;
        });

        if($user->defaultAddress){
            $user->defaultAddress()->update($request->except('first_name', 'last_name', 'email', 'payment_method', '_token', 'couponCode'));
        }else{
            $request->merge(['is_default' => 1]);
            $user->addresses()->create($request->except('first_name', 'last_name', 'email', 'payment_method', '_token', 'couponCode'));
        }

        $user->refresh();

        $shipping_cost = $user->defaultAddress->area->shipping_cost;


        $discount = 0;

        // Apply coupon if provided
        if ($request->filled('couponCode')) {
            $coupon = Coupon::where('code', $request->couponCode)
                ->where('active', 1)
                ->where(function($q) {
                    $q->whereNull('start_date')->orWhere('start_date', '<=', now());
                })
                ->where(function($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->first();

            if ($coupon) {
                // Check min_order
                if (!$coupon->min_order || $subtotal >= $coupon->min_order) {
                    // Check max usage
                    if (!$coupon->max_usage || $coupon->used_count < $coupon->max_usage) {
                        // Calculate discount
                        if ($coupon->type === 'fixed') {
                            $discount = $coupon->value;
                        } else { // percent
                            $discount = ($coupon->value / 100) * ($subtotal + $vat);
                        }

                        // Update used count
                        $coupon->increment('used_count');
                    }
                }
            }
        }

        $total = max(0, ($subtotal + $vat - $discount) + $shipping_cost);

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
                'vat_rate'       => $cartItems->sum(fn($item) => $item->product->tax->rate ?? 0),
                'vat'            => $vat,
                'sub_total'       => $subtotal,
                'shipping_cost'  => $shipping_cost,
                'discount'       => $discount,
                'discount_type'  => isset($coupon) ? $coupon->type : null,
                'total'          => $total,
                'payment_method' => $request->payment_method,
            ]);


            $order->address()->create([
                'address_id' => $user->defaultAddress->id
            ]);

            // Create items + attributes
            foreach ($cartItems as $item) {

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'stock_id' => $item->stock_id,
                    'qty'      => $item->quantity,
                    'price'    => $item->product->the_price['discounted'] ?? $item->product->the_price['original'],
                    'vat_rate' => $item->product->tax->rate ?? 0,
                    'vat'      => $item->product->tax_amount * $item->quantity,
                    'discount' => $item->product->the_discount ?? 0,
                    'sub_total' => $item->quantity * $item->product->price_with_tax,
                ]);

                $item->stock->update(['qty' => $item->stock->sum('qty') - $item->quantity]);

                $orderStock = Stock::create([
                    'product_id'     => $item->stock->product_id,
                    'stockable_type' => Order::class,
                    'stockable_id'   => $order->id,
                    'qty'            => -1 * $item->quantity, // 👈 السالب
                    'selling_price' => null, // أو السعر وقت البيع لو حابب
                ]);

                // Snapshot attributes
                foreach ($item->stock->attributes as $attr) {
                    OrderAttribute::create([
                        'order_item_id' => $orderItem->id,
                        'name'          => $attr->attribute->name,
                        'value'         => $attr->attributeValue->name,
                    ]);

                    StockAttribute::create([
                        'stock_id'           => $orderStock->id,
                        'attribute_id'       => $attr->attribute_id,
                        'attribute_value_id' => $attr->attribute_value_id,
                    ]);
                }
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', trans('main.order_placed_successfully'));

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors(['Error: ' . $e->getMessage()]);
        }

        }

        public function show(Order $order)
        {
            // تأمين: المستخدم يشوف أوردره بس
            abort_if($order->user_id !== auth()->id(), 403);

            $order->load([
                'items.stock.product.tax',
                'items.attributes',
                'address.address.area.parent.parent', // area -> governorate -> country
                'status'
            ]);

            return view('site.orders.show', compact('order'));
        }

        public function invoice(Order $order)
        {
            // تأمين: المستخدم يشوف أوردره بس
            abort_if($order->user_id !== auth()->id(), 403);

            $order->load([
                'items.stock.product.tax',
                'items.attributes',
                'address.address.area.parent.parent', // area -> governorate -> country
                'status'
            ]);

            return view('site.orders.invoice', compact('order'));
        }

}


