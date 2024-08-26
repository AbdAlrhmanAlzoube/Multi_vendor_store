<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // return view('produc')
    }
    public function show(Product $product)
    {
        if($product->status !='active'){ //مو انا بدي اعرض بس يلي حالتهم active  //لازم عالج حالة تعديل من وال url
            return abort('404');
        }

        return view('front.products.show', compact('product'));
    }
}
