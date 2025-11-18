<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class NameFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereTranslationLike('name', "%{$value}%");
    }
}
