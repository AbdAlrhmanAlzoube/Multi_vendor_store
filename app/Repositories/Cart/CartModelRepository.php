<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Cart\CartRepository;

class CartModelRepository implements CartRepository
{
        //OTP ONE TIME PASSWORD WHEN LOGIN SEND CODE FOR EMAIL
    protected $items;

    public function __construct()
    {
        $this->items=collect([]);
       

    }

    public function get(): Collection|array|null
    {
        
        if(!$this->items->count())
        {
          return  $this->items=Cart::with('product')
               ->get();
        }
        return $this->items;
    }

    public function add(Product $product, $quantity = 1)
    {
        $items = Cart::where('product_id', '=', $product->id)
            ->first();
        if (!$items) {
            $cart= Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'options' => json_encode([]),

            ]);
            $this->get()->push($cart);
            return $cart;
        }
        return $items->increment('quantity', $quantity);
        return $items;

    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->update([
                'quantity' => $quantity,
            ]);
    }
    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }


    public function empty()
    {
        Cart::query()->delete();
    }


    public function total()
    {
       return $this->get()->sum(function($item)
        {
            return $item->quantity * ($item->product ? $item->product->price : 0);
        });

        // return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(products.price * carts.quantity) as total')
        //     ->value('total') ?: 0.0;
    }
}
