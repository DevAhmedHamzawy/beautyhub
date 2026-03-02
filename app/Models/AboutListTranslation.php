<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutListTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'about_list_id',
        'locale',
        'title',
        'content',
    ];
}
