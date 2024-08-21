<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');
   

Route::get('products/',[ProductController::class, 'index'])->name('products.index');
Route::get('products/{product:slug}',[ProductController::class, 'show'])->name('products.show');

Route::post('paypal/webhook',function()
{
    echo 'success';
});

// Route::view('/layout', 'index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
