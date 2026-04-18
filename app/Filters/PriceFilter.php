<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PriceFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (!empty($value)) {

           return $builder->where(function ($query) use ($value) {

                $query->whereHas('defaultStock', function ($q) use ($value) {
                    $q->whereBetween('selling_price', [$value[0], $value[1]]);
                })

                ->orWhereHas('defaultStock.product', function ($q) use ($value) {
                    $q->whereBetween('selling_price', [$value[0], $value[1]]);
            });

        });

        }
    }
}
