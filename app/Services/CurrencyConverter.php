<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl='https://free.currencyconverter.com/api/v7';

    public function __construct(string $apiKey)
    {
        $this->apiKey=$apiKey;
    }

    public function converter(string $from,string $to,float $amount=null)
    {
        $q="{$from}_{$to}";
        $response= Http::baseUrl($this->baseUrl)
        ->get('/convert',[
            'q'=>$q,
            'compact'=>'y',
            'apikey'=>$this->apiKey,
        ]);
        $result =$response->json();
        return $result[$q]*$amount;
    }
}