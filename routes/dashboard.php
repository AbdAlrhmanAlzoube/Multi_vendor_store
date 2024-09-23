<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Providers\RouteServiceProvider;
use Illuminate\support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Front\ProductController as FrontProductController;
use App\Http\Middleware\CheckUserType;

Route::group([
    //'key'=>'الخاصية'
    'prefix'=>'dashboard',
    'middleware'=>['auth:admin'],//admin=>guardadmin     //'auth_type:admin,super-admin'
    'as'=>'dashboard.',
    'prefix'=>'admin/dashboard',
],

function()
{

    Route::get('profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/', [DashboardController::class,'index']);

    Route::get('/categories/trash',[CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore',[CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class, 'forceDelete'])->name('categories.force-delete');
    
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductController::class);
    // Route::resources([
    //     'products' => ProductController::class,
    //     'categories'=>CategoriesController::class,
       
    // ])  ;
    Route::resource( '/roles',RoleController::class);
    Route::resource( '/admins',AdminController::class);
    Route::resource( '/users',UsersController::class);
});

