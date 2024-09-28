<?php

namespace App\Http\Controllers;

use App\Http\Handler\CheckVerificationHandler;
class VerifyEmailController
{
    public function __construct(private readonly CheckVerificationHandler $handler)
    {
    }

    public function index(string $hash)
    {
        $message = $this->handler->handle($hash);

        return view('verify', compact('message'));
    }
}
