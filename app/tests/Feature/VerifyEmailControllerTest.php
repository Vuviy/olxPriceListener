<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => null
        ]);
    }

    public function test_email_verification_successful()
    {

        $hash = Crypt::encryptString('test@example.com');

        $response = $this->get("verify/{$hash}/email");

        $this->user->refresh();

        $this->assertNotNull($this->user->email_verified_at);

        $response->assertViewHas('message', 'Your Email Verified');
    }

    public function test_email_already_verified()
    {

        $this->user->update(['email_verified_at' => now()]);

        $hash = Crypt::encryptString('test@example.com');

        $response = $this->get("verify/{$hash}/email");

        $response->assertViewHas('message', 'This email has already been verified');
    }

    public function test_email_not_found()
    {
        $hash = Crypt::encryptString('nonexistent@example.com');

        $response = $this->get("verify/{$hash}/email");

        $response->assertViewHas('message', 'Something went wrong. Try again');
    }
}
