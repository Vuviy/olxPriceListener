<?php

namespace App\Http\Helper;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Models\Advertisement;
use App\Services\ApiOLXService;

class SetPriceHelper
{
    public static function setPrice(int $advertisementId)
    {

        $advertisement = Advertisement::query()->find($advertisementId);

//        $apiService = app(ApiService::class);
//        $price = $apiService->getPriceFromApi($link->ad_id);

// цим способом $price отримується довго так як OLX деякий час не оновлює ціну тому я застосував спосіб нижче

        $price = ParsePriceHelper::getPrice($advertisementId);

        if (null === $advertisement->price) {
            $advertisement->update(['price' => $price]);
            return;
        }

        if ($advertisement->price != $price) {
            $advertisement->update(['price' => $price]);

            SendMailJob::dispatch($advertisement->id);
        }

    }
}
