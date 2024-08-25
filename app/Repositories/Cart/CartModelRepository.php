<?php

namespace App\Repositories\Cart;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Cart\CartRepository;

class CartModelRepository implements CartRepository
{

    public function get():Collection
    {
        return Cart::with('product')
            ->where('cookie_id', '=', $this->getCookieId())
            ->get();
    }

    // أضف منتجًا إلى السلة
    public function add(Product $product, $quantity = 1)
    {
        return Cart::create([
            'cookie_id' => $this->getCookieId(),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,

        ]);
    }

    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
            ->where('cookie_id', '=', $this->getCookieId())
            ->update([
                'quantity' => $quantity,
            ]);
    }
    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->where('cookie_id', '=', $this->getCookieId())
            ->delete();
    }


    public function empty()
    {
        Cart::where('cookie_id', $this->getCookieId())->delete();
    }


    public function total(): float
    {
        return Cart::where('cookie_id', $this->getCookieId())
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total') ?: 0.0;
    }
    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            $cookieLifetime = config('session.cart_cookie_lifetime', 30); //;linkedin
            Cookie::queue('cart_id', $cookie_id, 30);
        }
        return $cookie_id;
    }
}
