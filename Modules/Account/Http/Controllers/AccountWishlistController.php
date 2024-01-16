<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;

class AccountWishlistController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('public.account.wishlist.index');
    }
}
