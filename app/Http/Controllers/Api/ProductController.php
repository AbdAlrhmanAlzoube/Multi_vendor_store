<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)      //laravel outomatec convert model collection to json
    {
        return Product::active()->Filter($request->query())
        ->with('category:id,name','store:id,name','tags:id,name') //respons id and name onle id use not matcheng laravel beetwean product name and category name
        ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Product::rules());

        $product = Product::create($validated);

        return  response()->json($product, 201, [
            'Loction'=> route('products.show',$product->id), // Response facade becose header 
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product->load('category:id,name','store:id,name','tags:id,name');  //return object  //with return bulider
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        $validated = $request->validate(Product::rules());

        $product->update($validated);
        return  response()->json($product, 201, [
            'Loction'=> route('products.show',$product->id), // Response facade becose header 
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       Product::destroy($id);
       return [                                         //laravel automatec array to json
        'massege'=>'Product Deleted Succsesfully'
       ];
    }
}
