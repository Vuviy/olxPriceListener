<?php

namespace App\Jobs;

use App\Http\Helper\SetPriceHelper;
use App\Mail\PriceNotificationMail;
use App\Models\Advertisement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly int $advertisementId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $advertisement = Advertisement::query()->find($this->advertisementId);

        foreach ($advertisement->verifiedUsers as $recipient) {
            Mail::to($recipient->email)->send(new PriceNotificationMail($advertisement));
        }
    }
}
