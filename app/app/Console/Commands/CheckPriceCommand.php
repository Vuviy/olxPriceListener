<?php

namespace App\Console\Commands;

use App\Http\Helper\SetPriceHelper;
use App\Models\Advertisement;
use Illuminate\Console\Command;

class CheckPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check price';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $advertisements = Advertisement::all();

        if (null !== $advertisements) {
            foreach ($advertisements as $advertisement) {
                SetPriceHelper::setPrice($advertisement->id);
            }
        }

        return Command::SUCCESS;
    }
}
