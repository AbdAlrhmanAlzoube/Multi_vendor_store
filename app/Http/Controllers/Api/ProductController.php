<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller implements HasMiddleware
{

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->except(['index','show']);
    // }

   /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except:['index','show']),
        ];
    }
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)      //laravel outmatchen convert model collection to json
    {
         $products= Product::active()->Filter($request->query())
        //->with('category:id,name','store:id,name','tags:id,name') //respons id and name onle id use not matcheng laravel beetwean product name and category name
        ->paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Product::rules());

        $product = Product::create($validated);

        $user=$request->user();
        if(!$user->tokenCan('products.create'))
        {
            abort(403,'Not allowed');
        }

        return  response()->json($product, 201, [
            'Loction'=> route('products.show',$product->id), // Response facade becose header 
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        //->load('category:id,name','store:id,name','tags:id,name');  //return object  //with return bulider
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        $validated = $request->validate(Product::rules());

        $user=$request->user();
        if(!$user->tokenCan('products.update'))
        {
            abort(403,'Not allowed');
        }

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

        $user=Auth::user();
        if(!$user->tokenCan('products.delete'))
        {
            return response([
                'massege'=> 'Not allowed',
            ],403);
            // abort(403,'Not allowed'); return massege and Exception
        }
       Product::destroy($id);
       return [                                         //laravel automatec array to json
        'massege'=>'Product Deleted Succsesfully'
       ];
    }
}
