<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
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

        }

    }


    public function show()
    {
        $locale = app()->getLocale();

        if(auth()->check()) {
            $cart = auth()->user()->cart()->get()->keyBy('stock_id');
        }else{
            $cart = collect(session('cart', []));
        }

        if ($cart->isEmpty()) {
            return view('cart.index', ['cartItems' => collect()]);
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
                'unit_price'   => $stock->selling_price, // أو $stock->price لو موجود
                'total'        => $stock->selling_price * $item['quantity'],
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

        return view('site.cart', compact('cartItems'));
    }
}
