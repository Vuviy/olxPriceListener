<?php

namespace App\Jobs;

use App\Http\Helper\ParseIdHelper;
use App\Http\Helper\ParserHelper;
use App\Http\Helper\SetPriceHelper;
use App\Models\Advertisement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public readonly int $advertisementId){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $advertisement = Advertisement::query()->find($this->advertisementId);

        $parser = new ParserHelper($advertisement);

        $id = $parser->getId();
        $price = $parser->getPrice();

        $advertisement->update(['ad_id' => $id, 'price' => $price]);
    }
}
