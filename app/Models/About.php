<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use Translatable;
    public $translatedAttributes = ['title', 'content'];
    protected $guarded = ['title', 'content'];

    public function lists()
    {
        return $this->hasMany(AboutList::class);
    }
}
