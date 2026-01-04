<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cart;
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
                    'price'        => $item->stock->selling_price ?? $item->stock->product->selling_price,
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
                    'subtotal'     => $item->quantity * ($item->stock->selling_price ?? $item->stock->product->selling_price),
                ];
            });


        $subtotal = $cartItems->sum('subtotal');

        $shipping_cost = Area::where('id', auth()->user()->defaultAddress->area_id)->first()->shipping_cost;

        return view('site.checkout.checkout', ['cartItems' => $cartItems, 'subtotal' => $subtotal, 'areas' => $areas, 'theCity' => $city, 'theGovernorate' => $governorate , 'theCountry' => $country, 'shipping_cost' => $shipping_cost]);
    }
}
