<?php

namespace Tests\Feature;

use App\Http\Helper\ParseIdHelper;
use App\Models\Advertisement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ParseIdHelperTest extends TestCase
{
    use RefreshDatabase;

    const string URL = 'https://www.olx.ua/d/uk/obyavlenie/tomati-sma4nenki-IDVfZ7y.html';

    private Advertisement $advertisement;

    protected function setUp(): void
    {
        parent::setUp();

        Advertisement::query()->create(['url' => self::URL]);

        $this->advertisement = Advertisement::query()->orderByDesc('id')->limit(1)->first();

    }


    public function test_getId_successfully_updates_advertisement()
    {
        ParseIdHelper::getId($this->advertisement->id);

        $advertisement = Advertisement::query()->orderByDesc('id')->limit(1)->first();

        $this->assertEquals($advertisement->url,self::URL);
        $this->assertNotNull($advertisement->ad_id);

    }


}
