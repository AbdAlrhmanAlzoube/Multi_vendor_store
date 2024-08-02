<?php

use Illuminate\support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;

Route::group([
    //'key'=>'الخاصية'
    'prefix'=>'dashboard',
    'middleware'=>'auth',
    'as'=>'dashboard.'
],

function()
{

    Route::get('/', [DashboardController::class,'index']);
    
    Route::resource('/categories',CategoriesController::class);
});

