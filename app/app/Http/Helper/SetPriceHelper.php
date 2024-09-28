<?php

namespace App\Http\Helper;

use App\Jobs\SendMailJob;
use App\Models\Advertisement;

class SetPriceHelper
{
    public static function setPrice(Advertisement $advertisement)
    {
        $parser = new ParserHelper($advertisement);

        $price = $parser->getPrice();

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
