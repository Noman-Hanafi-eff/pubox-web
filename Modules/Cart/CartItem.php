<?php

namespace Modules\Cart;

use stdClass;
use JsonSerializable;
use Modules\Support\Money;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariant;


class CartItem implements JsonSerializable
{
    public $id;
    public $qty;
    public $product;
    public $variant;
    public $item;
    public $options;
    public $variations;


    public function __construct($item)
    {
        $this->id = $item->id;
        $this->qty = $item->quantity;
        $this->product = $item->attributes['product'];
        $this->variant = $item->attributes['variant'];
        $this->item = $item->attributes['item'];
        $this->variations = $item->attributes['variations'];
        $this->options = $item->attributes['options'];
    }


    public function refreshStock()
    {
        $item = $this->getItem();

        $this->item->fill([
            'manage_stock' => $item->manage_stock,
            'in_stock' => $item->in_stock,
            'qty' => $item->qty,
        ]);

        return $this;
    }

    private function getProduct(){
        return Product::withName()
            ->addSelect('id', 'in_stock', 'manage_stock', 'qty', 'is_active')
            ->where('id', $this->product->id)
            ->first();
    }


    private function getVariant(){
            return ProductVariant::addSelect('id', 'in_stock', 'manage_stock', 'qty', 'is_active')
                ->where('id', $this->variant->id)
                ->first();
    }


    public function getItem()
    {
        if ($this->item instanceof ProductVariant) {
            return $this->getVariant();
        }

        return $this->getProduct();
    }


    public function findTax(array $addresses)
    {
        return $this->product->taxClass->findTaxRate($addresses);
    }


    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'product' => $this->product->clean(),
            'variant' => $this->variant?->clean(),
            'item' => $this->refreshStock()->item,
            'variations' => $this->variations->isNotEmpty() ? $this->variations->keyBy('position') : new stdClass,
            'options' => $this->options->isNotEmpty() ? $this->options->keyBy('position') : new stdClass,
            'unitPrice' => $this->unitPrice(),
            'total' => $this->totalPrice(),
        ];
    }


    public function unitPrice()
    {
        return $this->item->selling_price->add($this->optionsPrice());
    }


    public function optionsPrice(): Money
    {
        return Money::inDefaultCurrency($this->calculateOptionsPrice());
    }


    public function totalPrice()
    {
        return $this->unitPrice()->multiply($this->qty);
    }


    private function calculateOptionsPrice()
    {
        return $this->options->sum(function ($option) {
            return $this->sumOfTheValuesOf($option);
        });
    }


    private function sumOfTheValuesOf($option)
    {
        return $option->values->sum(function ($value) {
            if ($value->price_type === 'fixed') {
                return $value->price->amount();
            }

            return ($value->price / 100) * $this->item->selling_price->amount();
        });
    }
}
