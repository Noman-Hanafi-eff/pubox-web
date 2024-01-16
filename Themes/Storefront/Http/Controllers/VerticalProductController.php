<?php

namespace Themes\Storefront\Http\Controllers;

use Illuminate\Http\Response;

class VerticalProductController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $columnNumber
     *
     * @return Response
     */
    public function index($columnNumber)
    {
        return $this->getProducts("storefront_vertical_products_{$columnNumber}");
    }
}
