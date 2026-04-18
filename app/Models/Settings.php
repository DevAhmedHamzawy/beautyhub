<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $guarded = [];

    public function getLogoPathAttribute()
    {
        return url('storage/public/settings/'.$this->logo);
    }

    public function getFaviconPathAttribute()
    {
        return url('storage/public/settings/'.$this->favicon);
    }

    public function getFooterLogoPathAttribute()
    {
        return url('storage/public/settings/'.$this->footer_logo);
    }

    public function getBannerOnePathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_one);
    }

    public function getBannerTwoPathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_two);
    }

    public function getBannerThreePathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_three);
    }

    public function getBannerFourPathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_four);
    }

    public function getBannerFivePathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_five);
    }

    public function getBannerSixPathAttribute()
    {
        return url('storage/public/settings/'.$this->banner_six);
    }
}
