<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (!empty($value)) {
            return $builder->whereIn('category_id', $value);
        }

        return $builder;
    }
}
