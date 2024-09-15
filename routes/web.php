<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentactionController;

// تحديد المسار الافتراضي إذا لم يتم تمرير locale
// Route::get('/', function () {
//     $locale = config('app.locale'); // اللغة الافتراضية
//     return redirect($locale); // إعادة التوجيه إلى اللغة الافتراضية
// });

// استخدام مجموعة من المسارات مع `locale` كـ prefix
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    // 'middleware' => 'setlocale', // تمرير Middleware لضبط اللغة
    // 'where' => ['locale' => 'en|ar'], // اللغات المدعومة
], function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('products/', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    Route::resource('cart', CartController::class);
    
    Route::get('checkout', [CheckOutController::class,'create'])->name('checkout');
    Route::post('store-order', [CheckOutController::class, 'store'])->name('store-order');
    
    Route::get('auth/user/2fa', [TwoFactorAuthentactionController::class, 'index'])->name('front.2fa');
    
    Route::post('currency', [CurrencyConverterController::class, 'store'])->name('currency.store');
    
    Route::post('paypal/webhook', function() {
        echo 'success';
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/dashboard.php';
