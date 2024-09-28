<?php

namespace App\Http\Controllers\Api;

use App\Http\Handler\SubscribeProcessHandler;
use App\Http\Requests\SubscribeRequest;

class SubscribeController
{

    public function __construct(private readonly SubscribeProcessHandler $handler)
    {
    }

    public function index(SubscribeRequest $request)
    {
        $this->handler->handle($request);

        return response()->json(['message' => 'Data is valid']);
    }


}
