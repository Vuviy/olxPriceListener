<?php

namespace tests\Feature\Model;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;


    public function test_fillable_fields()
    {
        $data = [
            'email' => 'http://example.com/ad',
            'email_verified_at' => now(),
        ];

        User::create($data);

        $this->assertDatabaseHas('users', $data);
    }


    public function test_advertisements_relationship()
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->create();

        $user->advertisements()->attach($advertisement);

        $this->assertTrue($user->advertisements->contains($advertisement));
    }

}
