<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $requrst)
    {
        $requrst->validate([
            'currency_code'=>'required|string|size:3'
        ]);

        $baseCurrencyCode=config('app.currency');
        $currencyCode=$requrst->input('currency_code');

        $cachKey='currency_rate_' . $currencyCode;
        
        $rate=Cache::get($cachKey,0);

        if(!$rate)
        {
            $converter=new CurrencyConverter
            (config('services.currency_converter.api_key'));
            $rate=$converter->converter($baseCurrencyCode,$currencyCode);

            Cache::put($cachKey,$rate,now()->addMinutes(60));
        }

        Session::put('currency_code',$currencyCode);

        return redirect()->back();

    }
}
