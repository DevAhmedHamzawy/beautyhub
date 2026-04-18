<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BrandFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (!empty($value)) {
            return $builder->whereIn('brand_id', $value);
        }
        return $builder;
    }
}
