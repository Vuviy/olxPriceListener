<?php

namespace App\Http\Helper;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use DiDom\Document;

class ParseIdHelper extends Controller
{
    public static function getId(int $advertisementId)
    {
        $advertisement = Advertisement::query()->find($advertisementId);

        $document = new Document($advertisement->url, true);
        $idSpan = $document->first('.css-12hdxwj')->text();

        $advertisement->update(['ad_id' => (int)substr($idSpan, 4)]);
    }
}
