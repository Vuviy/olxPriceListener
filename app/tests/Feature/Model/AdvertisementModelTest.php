<?php

namespace tests\Feature\Model;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertisementModelTest extends TestCase
{
    use RefreshDatabase;


    public function test_fillable_fields()
    {
        $data = [
            'url' => 'http://example.com/ad',
            'ad_id' => 1234,
            'price' => 999.99
        ];

        Advertisement::create($data);

        $this->assertDatabaseHas('advertisements', $data);
    }


    public function test_users_relationship()
    {
        $advertisement = Advertisement::factory()->create();
        $user = User::factory()->create();

        $advertisement->users()->attach($user);

        $this->assertTrue($advertisement->users->contains($user));
    }


    public function test_verified_users_relationship()
    {
        $advertisement = Advertisement::factory()->create();
        $verifiedUser = User::factory()->create(['email_verified_at' => now()]);
        $unverifiedUser = User::factory()->create(['email_verified_at' => null]);

        $advertisement->users()->attach([$verifiedUser->id, $unverifiedUser->id]);

        $this->assertTrue($advertisement->verifiedUsers->contains($verifiedUser));
        $this->assertFalse($advertisement->verifiedUsers->contains($unverifiedUser));
    }
}
