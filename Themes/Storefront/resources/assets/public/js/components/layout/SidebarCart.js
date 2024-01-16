import store from "../../store";

export default {
    components: { SidebarCartItem: () => import("./SidebarCartItem.vue") },

    computed: {
        cart() {
            return store.state.cart;
        },

        cartIsEmpty() {
            return store.cartIsEmpty();
        },

        cartIsNotEmpty() {
            return !store.cartIsEmpty();
        },
    },

    mounted() {
        this.initEventListeners();
    },

    methods: {
        initEventListeners() {
            const sidebarCartWrap = $(".sidebar-cart-wrap");
            const overlay = $(".overlay");

            $(".header-cart").on("click", (e) => {
                e.stopPropagation();

                overlay.addClass("active");
                sidebarCartWrap.addClass("active");
            });

            $(".sidebar-cart-close").on("click", () => {
                overlay.removeClass("active");
                sidebarCartWrap.removeClass("active");
            });
        },
    },
};
