<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
   public function index()
   {
     $products=Product::with('category')
      ->active()->latest()->take(8)->get();
      // dd($products);
    return view('front.home',compact('products'));
   }
}
