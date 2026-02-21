<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getFullLocationAttribute()
    {
        if (!$this->area) return null;

        $area = $this->area;
        $parent = $area->parent;

        return $parent
            ? $area->name . '، ' . $parent->name . '، ' . $parent->parent->name
            : $area->name;
    }
}
