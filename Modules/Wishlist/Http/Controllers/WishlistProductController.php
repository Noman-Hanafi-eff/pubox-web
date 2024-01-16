<?php

namespace Modules\Wishlist\Http\Controllers;

use Illuminate\Http\Response;

class WishlistProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return auth()->user()
            ->wishlist()
            ->with('files')
            ->orderByPivot('created_at', 'desc')
            ->paginate(10);
    }
}
