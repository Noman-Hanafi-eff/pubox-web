<?php

namespace Modules\Wishlist\Http\Controllers;

use Illuminate\Http\Response;

class WishlistController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!auth()->user()->wishlistHas(request('productId'))) {
            auth()->user()->wishlist()->attach(request('productId'));
        }
    }


    /**
     * Destroy resources by the given id.
     *
     * @param string $productId
     *
     * @return void
     */
    public function destroy($productId)
    {
        auth()->user()->wishlist()->detach($productId);
    }
}
