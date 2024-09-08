<?php

namespace App\View\Components;

use App\Facdes\Cart;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items;

    public $total;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items=Cart::get(); //view products in cart
        $this->total=Cart::total(); //view price in cart
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}
