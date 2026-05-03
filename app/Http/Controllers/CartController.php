<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(CartRequest $request)
    {



        if(auth()->check()) {

            $cartItem = Cart::where('user_id', auth()->user()->id)->whereProductId($request->product_id)->whereStockId($request->stock_id)->first();

            if ($cartItem) {
                // المنتج موجود بالفعل → نزود الكمية
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // المنتج غير موجود بالفعل → ننشئ جديد
                $cart = $request->user()->cart()->create($request->validated());
            }

            // جلب الكارت كامل
            $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        }
        else{


            $cart = session()->get('cart', []);

            $key = $request->stock_id;

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $request->quantity;
            } else {
                $cart[$key] = [
                    'product_id' => $request->product_id,
                    'stock_id' => $request->stock_id,
                    'quantity' => $request->quantity,
                ];
            }

            session()->put('cart', $cart);

            // تحويل session cart لكوليكشن
            $cartItems = collect($cart)->map(function ($item) {
                return (object) [
                    'product'  => Product::find($item['product_id']),
                    'quantity' => $item['quantity'],
                    'stock'    => Stock::find($item['stock_id']),
                ];
            });

        }

        $items = [];
        $subtotal = 0;

        foreach ($cartItems as $item) {

            $price = $item->product->price_with_tax; // أو سعر stock لو عندك
            $subtotal += $price * $item->quantity;

            $items[] = [
                'id'    => $item->product->id,
                'name'  => $item->product->name,
                'price' => number_format($item->product->final_price, 2),
                'image' => $item->product->img_path ?? asset('images/no-image.png'),
                'stock' => $item->stock,
            ];
        }

        return response()->json([
            'message' => trans('main.added_to_cart'),
            'cart' => [
                'count'    => collect($cartItems)->sum('quantity'),
                'subtotal' => number_format($subtotal, 2),
                'items'    => $items
            ]
        ]);
    }


    public function show()
    {
        $locale = app()->getLocale();

        if(auth()->check()) {
            $cart = auth()->user()->cart()->get()->keyBy('stock_id');
        }else{
            $cart = collect(session()->get('cart', []))->map(function ($item) {

                $product = Product::find($item['product_id']);
                $stock   = Stock::find($item['stock_id']);

                if (!$product || !$stock) {
                    return null;
                }

                $cartItem = new Cart();

                $cartItem->quantity = $item['quantity'];
                $cartItem->stock_id = $stock->id;
                $cartItem->product_id = $product->id;

                // تسجيل العلاقات (عشان accessors تشتغل)
                $cartItem->setRelation('product', $product);
                $cartItem->setRelation('stock', $stock);

                return $cartItem;
            })->filter()->keyBy('stock_id');
        }

        if ($cart->isEmpty()) {
            return view('site.cart_empty', ['cartItems' => collect()]);
        }

        // نجيب كل الـ stock_ids
        $stockIds = $cart->pluck('stock_id')->toArray();

        // نجيب التفاصيل من قاعدة البيانات
        $stocks = \App\Models\Stock::with(['product', 'product.tax', 'attributes.attribute', 'attributes.attributeValue'])
            ->whereIn('id', $stockIds)
            ->get();

        // ندمج بيانات الـ session مع بيانات قاعدة البيانات
        $cartItems = $stocks->map(function ($stock) use ($cart, $locale) {

            $item = $cart->get($stock->id);

            return [
                'img_path'     => $stock->product->img_path,
                'product_id'   => $stock->product->id,
                'product_name' => $stock->product->translate(app()->getLocale())->name,
                'product_tax'  => $stock->product->tax->value,
                'stock_id'     => $stock->id,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item->product->the_price['discounted'] ?? $item->product->the_price['original'], // أو $stock->price لو موجود'
                'tax_rate'          => $item->product->tax->rate,
                'tax' =>            $item->product->tax_amount * $item['quantity'],
                'price_with_tax' => $item->product->price_with_tax,
                'total'        => $item->product->price_with_tax * $item['quantity'],
                'attributes'   =>  $stock->attributes->mapWithKeys(function ($attr) use ($locale) {
                                    $attrName = $attr->attribute
                                        ? ($attr->attribute->translate($locale)->name ?? $attr->attribute->name)
                                        : 'Unknown';

                                    $valueName = $attr->attributeValue
                                        ? ($attr->attributeValue->translate($locale)->name ?? $attr->attributeValue->name)
                                        : '';

                                    return [$attrName => $valueName];
                                    }),
            ];
        });

        $subtotal = $cartItems->sum('total');

        return view('site.cart', compact('cartItems', 'subtotal'));
    }

    public function update(Request $request)
    {
        if (auth()->check()) {

            $item = Cart::where('user_id', auth()->id())
                ->where('stock_id', $request->stock_id)
                ->firstOrFail();

            $item->update(['quantity' => $request->quantity]);

            $cartItems = Cart::with('product.tax','stock')
                ->where('user_id', auth()->id())
                ->get();

        } else {

            $cart = session()->get('cart', []);

            $cart[$request->stock_id]['quantity'] = $request->quantity;

            session()->put('cart', $cart);

            $cartItems = collect($cart)->map(function ($item) {
                return (object) [
                    'quantity' => $item['quantity'],
                    'product'  => Product::with('tax')->find($item['product_id']),
                    'stock'    => Stock::find($item['stock_id']),
                ];
            });
        }

        $items = [];
        $subtotal = 0;

        foreach ($cartItems as $item) {

            $unitPrice = $item->product->final_price;
            $unitTax   = $item->product->tax_amount;

            $lineTotal = ($unitPrice + $unitTax) * $item->quantity;

            $subtotal += $lineTotal;

            $items[$item->stock->id] = [
                'quantity' => $item->quantity,
                'tax'      => $item->product->tax_amount * $item->quantity,
                'total'    => number_format($lineTotal, 2),
            ];
        }

        return response()->json([
            'items'    => $items,
            'subtotal' => number_format($subtotal, 2),
        ]);
    }

    public function remove(Request $request)
    {
        $stockId = $request->stock_id;

        if (auth()->check()) {
            // حذف من DB
            Cart::where('user_id', auth()->id())
                ->where('stock_id', $stockId)
                ->delete();

            // جلب الكارت بعد الحذف
            $cartItems = Cart::where('user_id', auth()->id())
                ->with('product')
                ->get();

            $count = $cartItems->sum('quantity');
            $subtotal = $cartItems->sum(function ($item) {
                $price = $item->product->price_with_tax;
                return $price * $item->quantity;
            });

        } else {
            // حذف من session
            $cart = session()->get('cart', []);

            if (isset($cart[$stockId])) {
                unset($cart[$stockId]);
                session()->put('cart', $cart);
            }

            $cartItems = collect($cart)->map(function ($item) {
                $product = Product::find($item['product_id']);
                if (!$product) return null;
                $item['product'] = $product;
                return $item;
            })->filter();

            $count = $cartItems->sum('quantity');
            $subtotal = $cartItems->sum(function ($item) {
                $price = $item['product']->price_with_tax;
                return $price * $item['quantity'];
            });
        }

        return response()->json([
            'success' => true,
            'count' => $count,
            'message' => trans('main.cart_removed_successfully'),
            'subtotal' => number_format($subtotal, 2, '.', ''),
        ]);
    }
}
