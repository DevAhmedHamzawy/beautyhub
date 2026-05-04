<?php

namespace App\Helper;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

class SeoLinksShow
{
    public static function getLinks($title, $description, $graphUrl, $created_at, $category, $images)
    {
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('product:published_at', $created_at->toW3CString(), 'property');
        SEOMeta::addMeta('product:section', $category->name ?? $category, 'property');
        //SEOMeta::addKeyword(['key1', 'key2', 'key3']);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($graphUrl);
        OpenGraph::addProperty('type', 'estate');
        OpenGraph::addProperty('locale', 'ar-sa');

        OpenGraph::addImage($images);

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('Product');
        JsonLd::addImage($images);
    }
}
