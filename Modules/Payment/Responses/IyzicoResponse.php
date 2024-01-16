<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Iyzipay\Model\CheckoutFormInitialize;
use Modules\Payment\HasTransactionReference;

class IyzicoResponse extends GatewayResponse implements HasTransactionReference
{
    private $order;

    private CheckoutFormInitialize $clientResponse;


    public function __construct(Order $order, CheckoutFormInitialize $clientResponse)
    {
        $this->order = $order;
        $this->clientResponse = $clientResponse;
        dd($clientResponse);
    }


    public function getOrderId()
    {
        return $this->order->id;
    }


    public function getTransactionReference()
    {
    }


    public function toArray()
    {
        return [
            'checkoutFormContent' => $this->clientResponse->getCheckoutFormContent(),
        ];
    }
}
