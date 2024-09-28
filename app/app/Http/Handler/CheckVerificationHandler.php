<?php

namespace App\Http\Handler;

use App\Models\User;

class CheckVerificationHandler
{
    public function handle(string $hash): string
    {
        $user = User::query()->where('hash', $hash)->first();
        $message = 'User not found';

        if (null === $user) {
            return $message;
        }

        if (null !== $user->email_verified_at) {
            $message = 'This email has already been verified';
            return $message;
        }
        $user->update(['email_verified_at' => now()]);
        $message = 'Your Email Verified';

        return $message;
    }
}
