<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // الحصول على الـ locale من الطلب أو الكوكيز
        // $locale = $request->get('locale', Cookie::get('locale', config('app.locale')));
        $locale=request()->route('locale');
        // التحقق من أن الـ locale صالحة
        if (!in_array($locale, config('app.supported_locales'))) {
            $locale = config('app.locale'); // اللغة الافتراضية إذا كانت غير صالحة
        }

        // تعيين اللغة
        App::setLocale($locale);

        // حفظ اللغة في الكوكيز لمدة سنة
        // Cookie::queue('locale', $locale, 60 * 24 * 365);

        // ضبط الـ locale في الروابط
        URL::defaults([
            'locale' => $locale,
        ]);

        Route::current()->forgetParameter('locale');

        return $next($request);
    }
}
