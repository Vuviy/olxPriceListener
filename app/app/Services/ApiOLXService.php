<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class ApiOLXService
{

     const string URL = 'https://www.olx.ua/api/v1/targeting/data/?page=ad&params%5Bad_id%5D=';
     const string TOKEN = 'f8e3a4c7c92ecf18481b4c3dec36a8874e63fbd8';


    public function __construct(private readonly Client $client)
    {
    }

    public function getPriceFromApi(int $adId): int
    {
        $data = $this->request($adId);
        return (int)$data['data']['targeting']['ad_price'];
    }

    public function request(int $adId): array
    {
        $url = 'https://www.olx.ua/api/v1/targeting/data/?page=ad&params%5Bad_id%5D=';
        $token = 'f8e3a4c7c92ecf18481b4c3dec36a8874e63fbd8';

        try {
            $response = $this->client->request('GET', self::URL . $adId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . self::TOKEN,
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            return [$e->getMessage()];
        }
    }
}
