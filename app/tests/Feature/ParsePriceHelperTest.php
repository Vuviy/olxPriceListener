<?php

namespace Tests\Feature;

use App\Http\Helper\ParsePriceHelper;
use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParsePriceHelperTest extends TestCase
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


    public function testGetIdSuccessfullyUpdatesAdvertisement()
    {
        $this->assertNotNull(ParsePriceHelper::getPrice($this->advertisement->id));

    }

}
