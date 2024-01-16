<?php

namespace Modules\Payment\Gateways;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Modules\Payment\Responses\IyzicoResponse;

class Iyzico implements GatewayInterface
{

    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('iyzico_label');
        $this->description = setting('iyzico_description');
    }


    public function purchase(Order $order, Request $request)
    {
        $reference = 'ref' . time();
        # create request class
        $apiRequest = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $apiRequest->setLocale(\Iyzipay\Model\Locale::TR);
        $apiRequest->setConversationId("123456789");
        $apiRequest->setPrice("1");
        $apiRequest->setPaidPrice("1.2");
        $apiRequest->setCurrency(\Iyzipay\Model\Currency::TL);
        $apiRequest->setBasketId("B67832");
        $apiRequest->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $apiRequest->setCallbackUrl($this->getRedirectUrl($order, $reference));
        $apiRequest->setEnabledInstallments([2, 3, 6, 9]);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $apiRequest->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $apiRequest->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $apiRequest->setBillingAddress($billingAddress);

        $basketItems = [];
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("0.3");
        $basketItems[0] = $firstBasketItem;

        $secondBasketItem = new \Iyzipay\Model\BasketItem();
        $secondBasketItem->setId("BI102");
        $secondBasketItem->setName("Game code");
        $secondBasketItem->setCategory1("Game");
        $secondBasketItem->setCategory2("Online Game Items");
        $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $secondBasketItem->setPrice("0.5");
        $basketItems[1] = $secondBasketItem;

        $thirdBasketItem = new \Iyzipay\Model\BasketItem();
        $thirdBasketItem->setId("BI103");
        $thirdBasketItem->setName("Usb");
        $thirdBasketItem->setCategory1("Electronics");
        $thirdBasketItem->setCategory2("Usb / Cable");
        $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $thirdBasketItem->setPrice("0.2");
        $basketItems[2] = $thirdBasketItem;
        $apiRequest->setBasketItems($basketItems);

        $options = new \Iyzipay\Options();
        $options->setApiKey(setting('iyzico_api_key'));
        $options->setSecretKey(setting('iyzico_api_secret'));
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');
        # make request
        $response = \Iyzipay\Model\CheckoutFormInitialize::create($apiRequest, $options);

        return new IyzicoResponse($order, $response);
    }


    public function complete(Order $order)
    {
        // TODO: Implement complete() method.
    }


    private function getRedirectUrl($order, $reference)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'iyzico', 'reference' => $reference]);
    }
}
