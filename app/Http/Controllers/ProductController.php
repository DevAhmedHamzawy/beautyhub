<?php

namespace App\Http\Controllers;

use App\Helper\FlashSaleHelper;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $locale = app()->getLocale();

        $product->load('images',
        'stocks.attributes', // stock->attributes (pivot model) يحتوي على attribute_id, attribute_value_id
        'stocks.attributes.attribute', // العلاقة للـ attribute
        'stocks.attributes.attributeValue', // العلاقة لقيمة الـ attribute لو موجودة
        // تأكد إن Attribute لديها علاقة children أو attributeValues
        'stocks.attributes.attribute.children');

        // 1) حدد defaultStock: لو عندك علاقة defaultStock استخدمها، وإلا خليك على أول stock كـ fallback
        $defaultStock = $product->defaultStock ?? $product->stocks->first();

        // 2) بناء خريطة defaultAttributes: attribute_id => attribute_value_id
        $defaultAttributes = [];
        if ($defaultStock) {
            foreach ($defaultStock->attributes as $sa) {
                // افترض إن pivot أو model فيه attribute_id و attribute_value_id
                $defaultAttributes[$sa->attribute_id] = $sa->attribute_value_id;
            }
        }

        // 3) بناء قائمة Attributes مع كل القيم (values) ومع إضافة القيمة المحددة (selected)
        $attributes = $product->stocks
            ->flatMap->attributes // نجمع كل attributes عبر كل stocks لتحديد أي attributes موجودة
            ->groupBy('attribute_id')
            ->map(function ($group) use ($locale, $defaultAttributes) {
                $attributeModel = $group->first()->attribute;

                // جلب كل القيم الممكنة للـ attribute (children / attributeValues)
                $values = $attributeModel->children->map(function ($value) use ($locale) {
                    return [
                        'id' => $value->id,
                        'name' => $value->translate($locale)->name ?? $value->name ?? '',
                    ];
                })->values() ?? collect();

                return [
                    'id' => $attributeModel->id,
                    'name' => $attributeModel->translate($locale)->name ?? $attributeModel->name,
                    'values' => $values,
                    // القيمة المحددة (من defaultStock) أو null
                    'selected' => $defaultAttributes[$attributeModel->id] ?? null,
                ];
            })
            ->values();

        return view('site.products.show', ['product' => $product, 'attributes' => $attributes, 'defaultStockId' => $defaultStock->id]);

    }


    public function getPrice(Request $request, $productId)
    {
        $product = Product::with('stocks.attributes')->findOrFail($productId);
        $selectedAttributes = $request->input('attributes', []); // [attribute_id => value_id]

        // نحاول نلاقي stock اللي قيمه تطابق التحديدات
        $stock = $product->stocks->first(function ($stock) use ($selectedAttributes) {
            // نجمع attribute_value_ids للـ stock
            $ids = $stock->attributes->pluck('attribute_value_id', 'attribute_id')->toArray();
            // لازم كل selectedAttributes تكون متطابقة داخل $ids
            foreach ($selectedAttributes as $attrId => $valId) {
                if (! isset($ids[$attrId]) || $ids[$attrId] != $valId) {
                    return false;
                }
            }
            return true;
        });

        $price = $stock ? $stock->selling_price : '-';

        // فلاش سيل لو حابب تطبقه
        $flashSale = FlashSaleHelper::getActiveFlashSale();
        $discounted = null;
        if ($flashSale && $flashSale->products->contains($product->id)) {
            $discounted = $price - ($price * $flashSale->discount / 100);
        }

        return response()->json([
            'original' => $price,
            'discounted' => $discounted,
            'stock_id' => $stock ? $stock->id : null
        ]);
    }
}
