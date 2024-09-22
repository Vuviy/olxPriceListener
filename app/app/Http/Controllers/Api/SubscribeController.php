<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SubscribeRequest;
use App\Jobs\CheckPriceJob;
use App\Jobs\VerifyEmaillJob;
use App\Models\Advertisement;
use App\Models\User;

class SubscribeController
{

    public function index(SubscribeRequest $request)
    {

        $arrayLink = explode('.html', $request->link);

        $link = Advertisement::query()->where('url', $arrayLink[0].'.html')->first();

        if (null === $link) {
            $link = Advertisement::query()->create(['url' => $arrayLink[0].'.html']);
            CheckPriceJob::dispatch($link->id);
        }


        $user = User::query()->where('email', $request->email)->first();

        if (null === $user) {
            $user = User::query()->create(['email' => $request->email]);
            VerifyEmaillJob::dispatch($user->email);
        }

        $user->advertisements()->attach($link->id);

        return response()->json(['message' => 'Data is valid']);
    }

}
