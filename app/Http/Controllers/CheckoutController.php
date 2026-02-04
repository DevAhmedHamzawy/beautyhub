<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        if (!auth()->check()) {
            session(['redirect_after_auth' => 'checkout']);
            return redirect()->route('login');
        }

        $locale = app()->getLocale();

        $areas = Area::getMainAreas();

         // Get Current Country Then City
        $city = Area::where('id', auth()->user()->defaultAddress->area_id)->first();
        $city == null ? $governorate = null : $governorate = Area::where('id', $city->parent_id)->first();
        $governorate == null ? $country = null : $country = Area::where('id', $governorate->parent_id)->first();

        $cartItems = Cart::with(['stock.product', 'stock.attributes.attribute', 'stock.attributes.attributeValue'])
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($item) use($locale) {
                return [
                    'product_name' => $item->stock->product->name,
                    'price'        => $item->product->the_price['discounted'] ?? $item->product->the_price['original'],
                    'tax'          => $item->stock->product->tax->rate ?? 0,
                    'price_with_tax' => $item->product->price_with_tax,
                    'quantity'     => $item->quantity,
                    'attributes'   => $item->stock->attributes->mapWithKeys(function ($attr) use ($locale) {
                                    $attrName = $attr->attribute
                                        ? ($attr->attribute->translate($locale)->name ?? $attr->attribute->name)
                                        : 'Unknown';

                                    $valueName = $attr->attributeValue
                                        ? ($attr->attributeValue->translate($locale)->name ?? $attr->attributeValue->name)
                                        : '';

                                    return [$attrName => $valueName];
                                    }),
                    'subtotal'     => $item->quantity * ($item->product->price_with_tax),
                ];
            });


        $subtotal = $cartItems->sum('subtotal');

        $shipping_cost = Area::where('id', auth()->user()->defaultAddress->area_id)->first()->shipping_cost;

        return view('site.checkout.checkout', ['cartItems' => $cartItems, 'subtotal' => $subtotal, 'areas' => $areas, 'theCity' => $city, 'theGovernorate' => $governorate , 'theCountry' => $country, 'shipping_cost' => $shipping_cost]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $user = auth()->user();
        $cartItems = Cart::with('stock.product')->where('user_id', $user->id)->get();

        if($cartItems->isEmpty()) {
            return response()->json(['status'=>'error','message'=>'Your cart is empty.','original_total'=>0]);
        }

        $coupon = Coupon::where('code', $request->code)
            ->where('active', 1)
            ->where(function($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->first();

        if(!$coupon){
            return response()->json(['status'=>'error','message'=>'Invalid coupon code','original_total'=>$cartItems->sum(fn($item)=>$item->quantity*$item->stock->product->price_with_tax)]);
        }

        // تحقق من الحد الأدنى للطلب
        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->stock->product->price_with_tax);
        if($coupon->min_order && $subtotal < $coupon->min_order){
            return response()->json(['status'=>'error','message'=>'Order does not meet minimum for this coupon','original_total'=>$subtotal]);
        }

        // تحقق من عدد الاستخدامات
        if($coupon->max_usage && $coupon->used_count >= $coupon->max_usage){
            return response()->json(['status'=>'error','message'=>'Coupon has been fully used','original_total'=>$subtotal]);
        }

        // حساب الخصم
        if($coupon->type === 'fixed'){
            $discount = $coupon->value;
        } else { // percent
            $discount = ($coupon->value / 100) * $subtotal;
        }

        $new_total = max(0, $subtotal - $discount);

        return response()->json([
            'status'=>'success',
            'message'=>"Coupon applied: -$discount",
            'new_total'=>$new_total
        ]);
    }
}
