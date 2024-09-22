<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class VerifyEmailController
{

    public function index(string $hash)
    {

        $email = Crypt::decryptString($hash);

        $user = User::query()->where('email', $email)->first();

        $message = 'Something went wrong. Try again';

        if (null !== $user) {
            if (null !== $user->email_verified) {
                $message = 'This email has already been verified';
                return view('verify', compact('message'));
            }
            $user->update(['email_verified' => now()]);
            $message = 'Your Email Verified';
        }

        return view('verify', compact('message'));

    }

}
