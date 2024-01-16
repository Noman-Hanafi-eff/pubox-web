<?php

namespace Modules\Payment\Gateways;

use Exception;
use Iyzipay\Options;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Address;
use Illuminate\Http\Request;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\PaymentGroup;
use Modules\Order\Entities\Order;
use Iyzipay\Model\BasketItemType;
use Modules\Payment\GatewayInterface;
use Iyzipay\Model\CheckoutFormInitialize;
use Modules\Payment\Responses\IyzicoResponse;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;

class Iyzico implements GatewayInterface
{
    public const CURRENCIES = [
        "TRY",
        "EUR",
        "USD",
        "GBP",
        "IRR",
        "NOK",
        "RUB",
        "CHF",
    ];
    public $label;
    public $description;
    public Order $order;


    public function __construct()
    {
        $this->label = setting('iyzico_label');
        $this->description = setting('iyzico_description');
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        dd($order);
        if (!in_array(currency(), setting('iyzico_supported_currencies') ?? self::CURRENCIES)) {
            throw new Exception(trans('payment::messages.currency_not_supported'));
        }

        $this->order = $order;
        $reference = 'ref' . time();

        $apiOptions = $this->prepareApiOptions();
        $apiRequest = $this->prepareApiRequest();

        $response = CheckoutFormInitialize::create($apiRequest, $apiOptions);

        return new IyzicoResponse($order, $response);
    }


    public function complete(Order $order)
    {
        // TODO: Implement complete() method.
    }


    private function prepareApiOptions(): Options
    {
        $options = new Options();

        $options->setApiKey(setting('iyzico_api_key'));
        $options->setSecretKey(setting('iyzico_api_secret'));
        $options->setBaseUrl(setting('iyzico_test_mode') ? 'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com');

        return $options;
    }


    private function prepareApiRequest(): CreateCheckoutFormInitializeRequest
    {
        $apiRequest = new CreateCheckoutFormInitializeRequest();

        $buyer = $this->prepareBuyer();
        $shippingAddress = $this->prepareShippingAddress();
        $billingAddress = $this->prepareBillingAddress();
        $basketItems = $this->prepareBasketItems();

        $apiRequest->setLocale(locale() === 'tr' ? Locale::TR : Locale::EN);
        $apiRequest->setConversationId("123456789");
        $apiRequest->setPrice("1");
        $apiRequest->setPaidPrice("1.2");
        $apiRequest->setCurrency(setting('iyzico_supported_currency') ?? currency());
        $apiRequest->setBasketId($this->order->id);
        $apiRequest->setPaymentGroup(PaymentGroup::PRODUCT);
        $apiRequest->setCallbackUrl($this->getRedirectUrl($this->order, "ref"));
        $apiRequest->setBuyer($buyer);
        $apiRequest->setShippingAddress($shippingAddress);
        $apiRequest->setBillingAddress($billingAddress);
        $apiRequest->setBasketItems($basketItems);


        return $apiRequest;
    }


    private function getRedirectUrl($order, $reference)
    {
        return route('checkout.complete.store', [
            'orderId' => $order->id,
            'paymentMethod' => 'iyzico',
            'reference' => $reference,
        ]);
    }


    private function prepareBuyer()
    {
        $buyer = new Buyer();

        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");

        return $buyer;
    }


    private function prepareBillingAddress()
    {
        $billingAddress = new Address();

        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");

        return $billingAddress;
    }


    private function prepareShippingAddress()
    {
        $shippingAddress = new Address();

        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");

        return $shippingAddress;
    }


    private function prepareBasketItems()
    {
        $basketItems = [];

        foreach ($this->order->products as $orderProduct) {
            $basketItems[] = $this->prepareBasketItem($orderProduct);
        }

        return $basketItems;
    }


    private function prepareBasketItem($orderProduct)
    {
        $basketItem = new BasketItem();

        $basketItem->setId($orderProduct->id);
        $basketItem->setName($orderProduct->product->name);
        $basketItem->setItemType($orderProduct->product->is_virtual ? BasketItemType::VIRTUAL : BasketItemType::PHYSICAL);
        $basketItem->setPrice((float)$orderProduct->unit_price->convertToCurrentCurrency()->amount());

        return $basketItem;
    }
}
