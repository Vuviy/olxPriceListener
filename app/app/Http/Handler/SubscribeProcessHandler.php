<?php

namespace App\Http\Handler;

use App\Http\Requests\SubscribeRequest;
use App\Jobs\CheckPriceJob;
use App\Jobs\VerifyEmaillJob;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class SubscribeProcessHandler
{
    public function handle(SubscribeRequest $request)
    {
        $link = $this->convertLinkToCorrectFormat($request->link);

        $advertisement = Advertisement::query()->where('url', $link)->first();

        if (null === $advertisement) {
            $advertisement = Advertisement::query()->create(['url' => $link]);
            CheckPriceJob::dispatch($advertisement->id);
        }

        $user = User::query()->where('email', $request->email)->first();

        if (null === $user) {
            $hash = Crypt::encryptString(now(). $request->email);
            $user = User::query()->create(['email' => $request->email, 'hash' => $hash]);
            VerifyEmaillJob::dispatch($user->email, $hash);
        }

        $user->advertisements()->attach($advertisement->id);
    }

    private function convertLinkToCorrectFormat(string $link): string
    {
        $linkArray = explode('.html', $link);
        return \sprintf('%s.html', $linkArray[0]);
    }
}
