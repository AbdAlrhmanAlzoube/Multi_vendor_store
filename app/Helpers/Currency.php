<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{

    // ميثود invoke  تُستخدم لجعل الكلاس قابلاً للاستدعاء كدالة
    public function __invoke(...$parameter)
    {
        return static::format(...$parameter);  
    }
    public static function format($amount,$currency =null)
    {
        $baseCurrency=config('app.currency','USD');
        $formatter = new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
        if($currency === null){
            $currency=Session::get('currenty_code',$baseCurrency);
        }
        if($currency != $baseCurrency){
            $rate=Cache::get('currency_rate_' . $currency,1);
            $amount=$amount *$rate;
        }

        return $formatter->formatCurrency($amount,$currency);

    }
}