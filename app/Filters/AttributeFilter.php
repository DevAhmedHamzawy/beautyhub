<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AttributeFilter implements Filter
{
    public function apply(Builder $builder, $value)
    {
        // $value اللي جاي هنا هيبقى array بالشكل:
        // [ parent_id => [child_ids] ]

        if (!$value || !is_array($value)) {
            return $builder;
        }

        foreach ($value as $parentId => $childValues) {

            if (!is_array($childValues) || empty($childValues)) {
                continue;
            }

            // فلترة على stock attributes
            $builder->whereHas('stocks.attributes', function ($query) use ($childValues) {
                $query->whereIn('attribute_value_id', $childValues);
            });
        }

        return $builder;
    }
}

?>
