<?php

namespace App\Filters;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (!empty($value)) {

            $category = Category::whereId($value)->firstOrFail();

            if($category->parent_id != null){
                return $builder->whereIn('category_id', $value);
            }
            }else{
                $category = Category::whereId($value)->with('children')->firstOrFail();

                $ids = $category->subcategories->map(function ($s) {
                    return collect($s->toArray())
                        ->only(['id'])
                        ->all();
                });

                return $builder->whereIn('category_id', $ids);
            }

            return $builder;

    }
}
