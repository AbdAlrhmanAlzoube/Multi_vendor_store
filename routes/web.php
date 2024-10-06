<?php

use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentactionController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\SocialController;

// تحديد المسار الافتراضي إذا لم يتم تمرير locale
// Route::get('/', function () {
//     $locale = config('app.locale'); // اللغة الافتراضية
//     return redirect($locale); // إعادة التوجيه إلى اللغة الافتراضية
// });

// استخدام مجموعة من المسارات مع `locale` كـ prefix
Route::group([
    // 'prefix' => LaravelLocalization::setLocale(),
    // 'middleware' => 'setlocale', // تمرير Middleware لضبط اللغة
    // 'where' => ['locale' => 'en|ar'], // اللغات المدعومة
], function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('products/', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    Route::resource('cart', CartController::class);

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    
    Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socilaite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socilaite.callback');

Route::get('auth/{provider}/user', [SocialController::class, 'index']);
    
    Route::get('auth/user/2fa', [TwoFactorAuthentactionController::class, 'index'])->name('front.2fa');
    
    Route::post('currency', [CurrencyConverterController::class, 'store'])->name('currency.store');

    Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payments.create');

Route::post('orders/{order}/stripe/paymeny-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');

    
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
