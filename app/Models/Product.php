<?php

namespace App\Models;

use App\Filters\BaseFilter;
use App\Helper\FlashSaleHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    public $translatedAttributes = ['name', 'mini_description', 'description'];

    protected $guarded = ['name', 'mini_description', 'description' , 'main_image', 'images'];

    public function getRouteKeyName()
    {
        if (request()->is('admin/*')) {
            return 'id';
        }

        return 'slug';
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function defaultStock()
    {
        return $this->hasOne(Stock::class)->oldestOfMany();
    }

    public function wishlistedBy() {
        return $this->belongsToMany(User::class, 'wish_lists');
    }

    public function getImgPathAttribute()
    {
        return url('storage/public/products/'.$this->image);
    }

    public function getTheDiscountAttribute()
    {
        $flash_sale = FlashSaleHelper::getActiveFlashSale();

        if ($flash_sale && $flash_sale->products->contains($this->id)) {
            return $flash_sale->discount;
        }

        return null;
    }

    public function getThePriceAttribute()
    {
        $stock = $this->defaultStock;

        if (!$stock) {
            return null;
        }

        $flash_sale = FlashSaleHelper::getActiveFlashSale();

        if ($flash_sale && $flash_sale->products->contains($this->id)) {
            return [
                'original' => $stock->selling_price,
                'discounted' => $stock->selling_price - ($stock->selling_price * $flash_sale->discount / 100),
            ];
        }

        return [
            'original' => $stock->selling_price,
            'discounted' => null,
        ];
    }

    public static function scopeFilter(Builder $builder, $filters)
    {
        return (new BaseFilter(request()))->apply($builder, $filters);
    }
}
