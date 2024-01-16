<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Cart\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class CartController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('public.cart.index');
    }


    /**
     * Clear the cart.
     *
     * @return \Modules\Cart\Cart
     */
    public function clear(): \Modules\Cart\Cart
    {
        Cart::clear();

        return Cart::instance();
    }
}
