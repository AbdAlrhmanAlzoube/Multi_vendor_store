<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Collection;


class CartController extends Controller
{

    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($cart);
        // $repository = App::make('cart'); //service continer
        //   $items = $cart->get(); return :collection
        // dd($cart);
        $items = $this->cart->get();
        $total = $this->cart->total();
        return view('front.cart', [
            'cart' => $items,
            'total' => $total,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        // $repository=new CartModelRepository();
        $this->cart->add($product, $request->post('quantity'));
        return redirect()->route('cart.index')->with('success', 'added to cart!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            // 'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        // $product = Product::findOrFail($request->post('product_id'));
        // $repository=new CartModelRepository();
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $repository=new CartModelRepository();
        $this->cart->delete($id);
        return [
            'message'=>'item deleted!', //lindekin return response->json
        ];
    }
}
