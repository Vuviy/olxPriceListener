<?php

namespace Tests\Feature;


use App\Jobs\CheckPriceJob;
use App\Jobs\VerifyEmaillJob;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubscribeControllerTest extends TestCase
{

    const string URL = 'https://www.olx.ua/d/uk/obyavlenie/tomati-sma4nenki-IDVfZ7y.html';

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_subscribes_user_and_dispatches_jobs()
    {
        Queue::fake();

        $data = [
            'link' => self::URL,
            'email' => 'user@example.com',
        ];

        $response = $this->post('/api/subscribe', $data);

        $response->assertStatus(200);

        $advertisement = Advertisement::where('url', self::URL)->first();

        $this->assertNotNull($advertisement);

        $user = User::where('email', 'user@example.com')->first();
        $this->assertNotNull($user);

        $this->assertTrue($user->advertisements()->where('advertisement_id', $advertisement->id)->exists());

        Queue::assertPushed(CheckPriceJob::class, function ($job) use ($advertisement) {
            return $job->advertisementId === $advertisement->id;
        });

        Queue::assertPushed(VerifyEmaillJob::class, function ($job) use ($user) {
            return $job->email === $user->email;
        });
    }
}
