<?php

use Illuminate\support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\dashboard\ProductController;

Route::group([
    //'key'=>'الخاصية'
    'prefix'=>'dashboard',
    'middleware'=>'auth',
    'as'=>'dashboard.'
],

function()
{

    Route::get('/', [DashboardController::class,'index']);

    Route::get('/categories/trash',[CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore',[CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
    
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductController::class);
});

