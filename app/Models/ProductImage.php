<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $guarded = [];

    public function getImgPathAttribute()
    {
        return url('storage/public/products/'.$this->image);
    }
}
