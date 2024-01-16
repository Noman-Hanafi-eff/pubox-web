<template>
    <div class="cart-item sidebar-cart-item">
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
            >
                {{ cartItem.product.name }}
            </a>

            <ul
                v-if="Object.entries(cartItem.variations).length !== 0"
                class="list-inline product-options"
            >
                <li
                    v-for="(variation, key, index) in cartItem.variations"
                    :key="index"
                >
                    <label>{{ variation.name }}:</label>
                    {{ variation.values[0].label
                    }}{{
                        index === Object.values(cartItem.variations).length - 1
                            ? ""
                            : ","
                    }}
                </li>
            </ul>

            <ul
                v-if="Object.entries(cartItem.options).length !== 0"
                class="list-inline product-options"
            >
                <li v-for="option in cartItem.options" :key="option.id">
                    <label>{{ option.name }}:</label> {{ optionValues(option) }}
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
                            @input="
                                changeQuantity(
                                    cartItem,
                                    Number($event.target.value)
                                )
                            "
                            @keydown.up="
                                updateQuantity(cartItem, cartItem.qty + 1)
                            "
                            @keydown.down="
                                updateQuantity(cartItem, cartItem.qty - 1)
                            "
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

                <div class="product-price">
                    x {{ cartItem.unitPrice.inCurrentCurrency.formatted }}
                </div>
            </div>
        </div>

        <div class="remove-cart-item">
            <button class="btn-remove" @click="remove">
                <i class="las la-times"></i>
            </button>
        </div>
    </div>
</template>

<script>
import store from "../../store";
import CartItemHelpersMixin from "../../mixins/CartItemHelpersMixin";

export default {
    mixins: [CartItemHelpersMixin],

    props: ["cartItem"],

    methods: {
        updateCart(cartItem, qty) {
            axios
                .put(
                    route("cart.items.update", {
                        id: cartItem.id,
                        ...(store.hasCoupon() && {
                            coupon_code: store.getCoupon(),
                        }),
                    }),
                    {
                        qty: qty || 1,
                    }
                )
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch(({ response }) => {
                    store.updateCart(response.data.cart);

                    this.$notify(response.data.message);
                });
        },

        remove() {
            store.removeCartItem(this.cartItem);

            axios
                .delete(
                    route("cart.items.destroy", {
                        id: this.cartItem.id,
                        ...(store.hasCoupon() && {
                            coupon_code: store.getCoupon(),
                        }),
                    })
                )
                .then((response) => {
                    store.updateCart(response.data);
                });
        },
    },
};
</script>
