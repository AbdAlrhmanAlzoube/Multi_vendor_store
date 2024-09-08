<?php

namespace App\Http\Controllers\front;

use App\Events\CartCreated;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cart\CartRepository;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckOutController extends Controller
{
    public function create(CartRepository $cart)
    {
        // dd('abd');
        // dd($cart);
        // $cartitems=$cart->get();
        // if($cartitems->count() === 0)
        // {
        //     return redirect()->route('home');
        // }
        return view('front.checkout',[
            'cart'=>$cart,
            'countries'=>Countries::getNames(),
        ]);
    }
    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            
        ]);
        // dd('abd');

        DB::beginTransaction();

        $items=$cart->get()->groupBy('product.store_id');
        // dd($items);
        try{
            foreach($items as $store_id =>$cart_item){ //($items as $store_id => $cart_item
            $order=Order::create([
                'store_id'=>$store_id,
                'user_id'=>Auth::id(),
                'payment_method'=>'cod',
                
            ]);
            // dd($order);

    
            foreach($cart_item as $item)
            {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item->product_id,
                    'product_name'=>$item->product->name,
                    'price'=>$item->product->price,
                    'quantity'=>$item->quantity,
                ]);
            }
    
            foreach($request->post('addr')as $type =>$address)
            {
                $address['type']=$type;
                $order->addresses()->create($address);
            }

        }
        // $cart->empty();
            DB::commit();
            // event('cart.created',$order,Auth::user()); //listener empitycart and quantity --
            event(new CartCreated($order));
        }catch(Throwable $e){
             DB::rollBack();
            throw $e;
        }
        return to_route('home');
       
    }
}
