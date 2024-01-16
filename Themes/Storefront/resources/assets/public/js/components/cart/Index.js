import store from "../../store";
import CartHelpersMixin from "../../mixins/CartHelpersMixin";
import CartItemHelpersMixin from "../../mixins/CartItemHelpersMixin";

export default {
    mixins: [CartHelpersMixin, CartItemHelpersMixin],

    data() {
        return {
            shippingMethodName: null,
            crossSellProducts: [],
        };
    },

    computed: {
        hasAnyCrossSellProduct() {
            return this.crossSellProducts.length !== 0;
        },
    },

    created() {
        this.$nextTick(() => {
            if (store.state.cart.shippingMethodName) {
                this.changeShippingMethod(store.state.cart.shippingMethodName);
            } else {
                this.updateShippingMethod(this.firstShippingMethod);
            }

            this.fetchCrossSellProducts();
        });
    },

    methods: {
        updateCart(cartItem, qty) {
            this.loadingOrderSummary = true;

            axios
                .put(route("cart.items.update", { id: cartItem.id }), {
                    qty: qty || 1,
                })
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch(({ response }) => {
                    store.updateCart(response.data.cart);

                    this.$notify(response.data.message);
                })
                .finally(() => {
                    this.loadingOrderSummary = false;
                });
        },

        removeCartItem(cartItem) {
            this.loadingOrderSummary = true;

            store.removeCartItem(cartItem);

            if (store.cartIsEmpty()) {
                this.crossSellProducts = [];
            }

            axios
                .delete(route("cart.items.destroy", { id: cartItem.id }))
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                })
                .finally(() => {
                    this.loadingOrderSummary = false;
                });
        },

        clearCart() {
            store.clearCart();

            if (store.cartIsEmpty()) {
                this.crossSellProducts = [];
            }

            axios
                .delete(route("cart.clear"))
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                });
        },

        changeShippingMethod(shippingMethodName) {
            this.shippingMethodName = shippingMethodName;
        },

        async fetchCrossSellProducts() {
            try {
                const response = await axios.get(
                    route("cart.cross_sell_products.index")
                );

                this.crossSellProducts = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            }
        },
    },
};
