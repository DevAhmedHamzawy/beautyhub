<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SortFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (!empty($value)) {

           if ($value == 'price_asc') {

                return $builder->withAggregate('defaultStock', 'selling_price')
                            ->orderByRaw("
                                COALESCE(default_stock_selling_price, products.selling_price) ASC
                            ");
            }

            if ($value == 'price_desc') {
                 return $builder->withAggregate('defaultStock', 'selling_price')
                            ->orderByRaw("
                                COALESCE(default_stock_selling_price, products.selling_price) DESC
                            ");
            }

            if ($value == 'newest') {
                $builder->latest();
            }
        }
    }
}
