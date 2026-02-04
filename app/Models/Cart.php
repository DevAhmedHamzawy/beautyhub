<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUnitPriceAttribute()
    {
        return $this->product->the_price['discounted']
            ?? $this->product->the_price['original'];
    }

    public function getTotalAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}
