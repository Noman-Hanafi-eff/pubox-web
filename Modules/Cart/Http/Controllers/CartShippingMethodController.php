<?php

namespace Modules\Cart\Http\Controllers;

use Exception;
use Modules\Cart\Facades\Cart;
use Illuminate\Pipeline\Pipeline;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Checkers\ValidCoupon;
use Modules\Coupon\Checkers\CouponExists;
use Modules\Coupon\Checkers\MinimumSpend;
use Modules\Coupon\Checkers\MaximumSpend;
use Modules\Coupon\Checkers\AlreadyApplied;
use Modules\Shipping\Facades\ShippingMethod;
use Modules\Coupon\Checkers\ExcludedProducts;
use Modules\Coupon\Checkers\ApplicableProducts;
use Modules\Coupon\Checkers\ExcludedCategories;
use Modules\Coupon\Checkers\UsageLimitPerCoupon;
use Modules\Coupon\Checkers\ApplicableCategories;
use Modules\Coupon\Checkers\UsageLimitPerCustomer;

class CartShippingMethodController
{
    private array $checkers = [
        CouponExists::class,
        AlreadyApplied::class,
        ValidCoupon::class,
        MinimumSpend::class,
        MaximumSpend::class,
        ApplicableProducts::class,
        ExcludedProducts::class,
        ApplicableCategories::class,
        ExcludedCategories::class,
        UsageLimitPerCoupon::class,
        UsageLimitPerCustomer::class,
    ];


    /**
     * Store a newly created resource in storage.
     *
     * @return \Modules\Cart\Cart
     */
    public function store()
    {
        $shippingMethod = ShippingMethod::get(request('shipping_method'));

        Cart::addShippingMethod($shippingMethod);

        $cartWithCoupon = null;
        $couponCode = request()->query('coupon_code');

        if ($couponCode) {
            $coupon = Coupon::findByCode($couponCode);

            try {
                resolve(Pipeline::class)
                    ->send($coupon)
                    ->through($this->checkers)
                    ->then(function ($coupon) use (&$cartWithCoupon) {
                        Cart::applyCoupon($coupon);

                        $cartWithCoupon = json_encode(Cart::instance());

                        Cart::removeCoupon();
                    });
            } catch (Exception) {
                //Just suppressing the exception
            }
        }

        return $cartWithCoupon ?? Cart::instance();
    }
}
