<?php

namespace App\Http\Controllers\front;

use App\Events\CartCreated;
use App\Exceptions\InvalidOrderException;
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

        $cartitems=$cart->get();
        // if($cartitems->count() === 0)

        // {
        //   return new InvalidOrderException('cart is empty');
        // }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            // 'addr.billing.first_name' => 'required|string|max:255',
            // 'addr.billing.last_name' => 'required|string|max:255',
            // 'addr.billing.email' => 'email|max:255',
            // 'addr.billing.phone_number' => 'required|string|max:15',
            // 'addr.billing.street_address' => 'required|string|max:255',
            // 'addr.billing.city' => 'required|string|max:255',
            // 'addr.billing.postal_code' => 'nullable|string|max:10',
            // 'addr.billing.state' => 'nullable|string|max:255',
            // 'addr.billing.country' => 'required|string|size:2',

            // 'addr.shipping.first_name' => 'required|string|max:255',
            // 'addr.shipping.last_name' => 'required|string|max:255',
            // 'addr.shipping.email' => 'required|email|max:255',
            // 'addr.shipping.phone_number' => 'required|string|max:15',
            // 'addr.shipping.street_address' => 'required|string|max:255',
            // 'addr.shipping.city' => 'required|string|max:255',
            // 'addr.shipping.postal_code' => 'nullable|string|max:10',
            // 'addr.shipping.state' => 'nullable|string|max:255',
            // 'addr.shipping.country' => 'required|string|size:2',
        ]);
        // dd('abd');

        DB::beginTransaction();

        $items = $cart->get()->groupBy('product.store_id');
        // dd($items);
        try {
            foreach ($items as $store_id => $cart_item) { //($items as $store_id => $cart_item
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',

                ]);
                // dd($order);


                foreach ($cart_item as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            // $cart->empty();
            DB::commit();
            // event('cart.created',$order,Auth::user()); //listener empitycart and quantity --
            // event(new CartCreated($order));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        // dd($order);
        return redirect()->route('orders.payments.create', $order->id);
    }
}
