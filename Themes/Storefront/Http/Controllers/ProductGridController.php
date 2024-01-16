<?php

namespace Themes\Storefront\Http\Controllers;

use Illuminate\Http\Response;

class ProductGridController extends ProductIndexController
{
    /**
     * Display a listing of the resource.
     *
     * @param int $tabNumber
     *
     * @return Response
     */
    public function index($tabNumber)
    {
        return $this->getProducts("storefront_product_grid_section_tab_{$tabNumber}");
    }
}
