<?php

namespace Tests\Feature;

use App\Http\Helper\SetPriceHelper;
use App\Jobs\CheckPriceJob;
use App\Jobs\SendMailJob;
use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class SetPriceHelperTest extends TestCase
{

    use RefreshDatabase;

    const string URL = 'https://www.olx.ua/d/uk/obyavlenie/tomati-sma4nenki-IDVfZ7y.html';
    const int AD_ID = 860837360;

    private Advertisement $advertisement;

    protected function setUp(): void
    {
        parent::setUp();

        Advertisement::query()->create(['url' => self::URL, 'ad_id' => self::AD_ID]);

        $this->advertisement = Advertisement::query()->orderByDesc('id')->limit(1)->first();

    }

    public function test_set_price_with_null()
    {
        Queue::fake();

        SetPriceHelper::setPrice($this->advertisement->id);

        $advertisement = Advertisement::query()->orderByDesc('id')->limit(1)->first();

        $this->assertNotNull($advertisement->price);

    }

    public function test_set_price_with_old_price()
    {
        Queue::fake();

        $advertisement = Advertisement::query()->orderByDesc('id')->limit(1)->first();
        $advertisement->update(['price' => 10000]);

        SetPriceHelper::setPrice($this->advertisement->id);

        $this->assertNotNull($advertisement->price);

        Queue::assertPushed(SendMailJob::class, function ($job) use ($advertisement) {
            return $job->advertisementId === $advertisement->id;
        });

    }
}
