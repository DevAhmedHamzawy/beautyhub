<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use Translatable, SoftDeletes;
    public $translatedAttributes = ['question', 'answer'];
    protected $guarded = ['question', 'answer'];
}
