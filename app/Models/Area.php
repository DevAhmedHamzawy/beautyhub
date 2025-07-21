<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    public static function getMainAreas()
    {
        return self::whereParentId(1)->get();
    }
}
