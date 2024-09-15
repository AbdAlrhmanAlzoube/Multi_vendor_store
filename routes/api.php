<?php

use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AccessTokensController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('products',ProductController::class);  

Route::post('auth/access-tokens',[AccessTokensController::class, 'store'])
->middleware('guest:sanctum');

Route::delete('auth/access-tokens{token?}',[AccessTokensController::class, 'destroy'])
->middleware('auth:sanctum');