<aside class="order-summary-wrap">
    <div class="order-summary">
        <div class="order-summary-top">
            <h3 class="section-title">{{ trans('storefront::cart.order_summary') }}</h3>

            <ul class="cart-items list-inline">
                <li class="cart-item" v-for="cartItem in cart.items" :key="cartItem.id">
                    <a :href="productUrl(cartItem)" class="product-image">
                        <img
                            :src="baseImage(cartItem)"
                            :class="{
                                'image-placeholder': !hasBaseImage(cartItem),
                            }"
                            :alt="cartItem.product.name"
                        />
                    </a>

                    <div class="product-info">
                        <a
                            :href="productUrl(cartItem)"
                            class="product-name"
                            :title="cartItem.product.name"
                            v-text="cartItem.product.name"
                        >
                        </a>

                        <ul
                            v-if="Object.entries(cartItem.variations).length !== 0"
                            class="list-inline product-options"
                        >
                            <li
                                v-for="(variation, key, index) in cartItem.variations"
                                :key="index"
                            >
                                <label>@{{ variation.name }}:</label>
                                @{{ variation.values[0].label }}@{{ index === Object.values(cartItem.variations).length - 1 ? "" : "," }}
                            </li>
                        </ul>

                        <ul
                            v-if="Object.entries(cartItem.options).length !== 0"
                            class="list-inline product-options"
                        >
                            <li v-for="option in cartItem.options" :key="option.id">
                                <label>@{{ option.name }}:</label> @{{ optionValues(option) }}
                            </li>
                        </ul>

                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <div class="number-picker">
                                <div class="input-group-quantity">
                                    <button
                                        type="button"
                                        class="btn btn-number btn-minus"
                                        :disabled="cartItem.qty <= 1"
                                        @click="updateQuantity(cartItem, cartItem.qty - 1)"
                                    >
                                        -
                                    </button>

                                    <input
                                        type="text"
                                        :value="cartItem.qty"
                                        min="1"
                                        :max="maxQuantity(cartItem)"
                                        class="form-control input-number input-quantity"
                                        @focus="$event.target.select()"
                                        @input="changeQuantity(cartItem, Number($event.target.value))"
                                        @keydown.up="updateQuantity(cartItem, cartItem.qty + 1)"
                                        @keydown.down="updateQuantity(cartItem, cartItem.qty - 1)"
                                    />

                                    <button
                                        type="button"
                                        class="btn btn-number btn-plus"
                                        :disabled="isQtyIncreaseDisabled(cartItem)"
                                        @click="updateQuantity(cartItem, cartItem.qty + 1)"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="product-price">x @{{ cartItem.unitPrice.inCurrentCurrency.formatted }}</div>
                        </div>
                    </div>

                    <div class="remove-cart-item">
                        <button type="button" class="btn-remove" @click="removeCartItem(cartItem)">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                </li>
            </ul>

            @include('public.checkout.create.coupon')
        </div>

        <div class="order-summary-middle" :class="{ loading: loadingOrderSummary }">
            <ul class="list-inline order-summary-list">
                <li>
                    <label>{{ trans('storefront::cart.subtotal') }}</label>

                    <span v-html="cart.subTotal.inCurrentCurrency.formatted">
                    </span>
                </li>

                <li v-for="tax in cart.taxes">
                    <label v-text="tax.name"></label>

                    <span v-html="tax.amount.inCurrentCurrency.formatted">
                    </span>
                </li>

                <li v-if="hasCoupon">
                    <label>
                        {{ trans('storefront::cart.coupon') }}

                        <span class="coupon-code">
                            (@{{ cart.coupon.code }})
                            <span class="btn-remove-coupon" @click="removeCoupon">
                                <i class="las la-times"></i>
                            </span>
                        </span>
                    </label>

                    <span class="color-primary" v-html="'-' + cart.coupon.value.inCurrentCurrency.formatted">
                    </span>
                </li>

                <li v-if="hasShippingMethod">
                    <label>
                        {{ trans('storefront::cart.shipping_cost') }}
                    </label>

                    <span
                        :class="{ 'color-primary': hasFreeShipping }"
                        v-text="hasFreeShipping ? '{{ trans('storefront::cart.free') }}' : cart.shippingCost.inCurrentCurrency.formatted"
                    >
                    </span>
                </li>
            </ul>

            <div class="order-summary-total">
                <label>{{ trans('storefront::cart.total') }}</label>

                <span v-html="cart.total.inCurrentCurrency.formatted"></span>
            </div>
        </div>

        <div class="order-summary-bottom">
            <div class="form-group checkout-terms-and-conditions">
                <div class="form-check">
                    <input type="checkbox" v-model="form.terms_and_conditions" id="terms-and-conditions">

                    <label for="terms-and-conditions" class="form-check-label">
                        {{ trans('storefront::checkout.i_agree_to_the') }}
                        <a href="{{ $termsPageURL }}">
                            {{ trans('storefront::checkout.terms_&_conditions') }}
                        </a>
                    </label>

                    <span class="error-message" v-if="errors.has('terms_and_conditions')"
                        v-text="errors.get('terms_and_conditions')"></span>
                </div>
            </div>

            <div id="paypal-button-container" v-if="form.payment_method === 'paypal'"></div>

            <button
                v-cloak
                type="button"
                class="btn btn-primary btn-place-order"
                :class="{ 'btn-loading': placingOrder }"
                :disabled="!form.terms_and_conditions"
                @click="placeOrder"
                v-else
            >
                {{ trans('storefront::checkout.place_order') }}
            </button>
        </div>
    </div>
</aside>
