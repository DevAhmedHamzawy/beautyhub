<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Attribute::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Attribute::class, 'parent_id');
    }
}
