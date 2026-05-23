<?php

namespace App\Filters;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        if (empty($value)) {
            return $builder;
        }

        $categoryIds = collect();

        $categories = Category::with('children')
            ->whereIn('id', $value)
            ->get();

        foreach ($categories as $category) {

            // ضيف الـ category نفسها
            $categoryIds->push($category->id);

            // لو عنده children ضيفهم
            if ($category->children->count()) {
                $categoryIds = $categoryIds->merge(
                    $category->children->pluck('id')
                );
            }
        }

        return $builder->whereIn(
            'category_id',
            $categoryIds->unique()->toArray()
        );
    }
}
