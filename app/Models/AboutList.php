<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AboutList extends Model
{
    use Translatable;
    public $translatedAttributes = ['title', 'content'];
    protected $guarded = ['title', 'content'];
}
