<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CouponNotExistsException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => trans('coupon::messages.not_exists'),
        ], 404);
    }
}
