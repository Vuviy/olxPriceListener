<?php

namespace App\Http\Helper;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use DiDom\Document;

class ParsePriceHelper extends Controller
{
    public static function getPrice(int $advertisementId)
    {
        $advertisement = Advertisement::query()->find($advertisementId);

        $document = new Document($advertisement->url, true);
        $price = $document->first('.css-90xrc0')->text();

        $price = preg_replace('/[^\d.]/', '', $price);

        return rtrim($price, '.');
    }
}
