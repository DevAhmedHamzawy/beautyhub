<?php

namespace App\Helper;

use App\Models\FlashSale;
use Illuminate\Support\Facades\Cache;

class FlashSaleHelper
{
     public static function getActiveFlashSale()
    {
        return Cache::remember('flash_sales', now()->addMinutes(5), function () {
            return FlashSale::where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->with('products')
                ->first();
        });
    }
}
