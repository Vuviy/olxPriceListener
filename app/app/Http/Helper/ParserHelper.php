<?php

namespace App\Http\Helper;

use App\Models\Advertisement;
use DiDom\Document;

class ParserHelper
{
    const string ID_CLASS = '.css-12hdxwj';
    const string PRICE_CLASS = '.css-90xrc0';

    public function __construct(private readonly Advertisement $advertisement)
    {
    }

    public function getId()
    {
        $id = $this->perse($this->advertisement->url, self::ID_CLASS);
        return $this->convertIdToCorrectFormat($id);
    }

    public function getPrice(): string
    {
        $price = $this->perse($this->advertisement->url, self::PRICE_CLASS);
        return $this->convertPriceToCorrectFormat($price);
    }

    private function perse(string $url, string $class)
    {
        $document = new Document($url, true);
        return $document->first($class)->text();
    }

    private function convertPriceToCorrectFormat(string $price): string
    {
        $price = preg_replace('/[^\d.]/', '', $price);
        return rtrim($price, '.');
    }

    private function convertIdToCorrectFormat(string $id): int
    {
        return (int)substr($id, 4);
    }
}
