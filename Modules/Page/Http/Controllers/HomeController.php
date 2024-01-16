<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Response;

class HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('public.home.index');
    }
}
