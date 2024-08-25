<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Support\Collection;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        // $repository = App::make('cart');
        //   $items = $cart->get();
        // dd($cart);
        $items = $cart->get();

        // تمرير البيانات إلى الفيو
        return view('front.cart', [
            'cart' => $items,
        ]);
          
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id'=>['required','integer','exists:products,id'],
            'quantity'=>['nullable','int','min:1'],
        ]);

        $product=Product::findOrFail($request->post('product_id'));
        // $repository=new CartModelRepository();
        $cart->add($product,$request->post('quantity'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id'=>['required','integer','exists:products,id'],
            'quantity'=>['nullable','int','min:1'],
        ]);

        $product=Product::findorfile($request->post('product_id'));
        // $repository=new CartModelRepository();
        $cart->update($product,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart,$id)
    {
        // $repository=new CartModelRepository();
        $cart->delete($id);
        }
}
