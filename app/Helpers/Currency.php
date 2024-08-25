<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{

    // ميثود invoke السحرية، تُستخدم لجعل الكلاس قابلاً للاستدعاء كدالة
    public function __invoke(...$parameter)
    {
        return static::format(...$parameter); // هنا يتم تصحيح الخطأ
    }
    public static function format($amount,$currency =null)
    {
        $formatter = new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
        if($currency === null){
            $currency=config('app.currency','USD');
        }

        return $formatter->formatCurrency($amount,$currency);

    }
}