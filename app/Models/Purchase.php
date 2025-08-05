<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function stocks()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
