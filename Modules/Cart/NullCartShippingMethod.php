<?php

namespace Modules\Cart;

use Modules\Support\Money;

class NullCartShippingMethod
{
    public function name()
    {
        //
    }


    public function title()
    {
        //
    }


    public function cost(): Money
    {
        return Money::inDefaultCurrency(0);
    }
}
