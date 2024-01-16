export default {
    data() {
        return {
            email: "",
            subscribed: false,
            subscribing: false,
            error: "",
            disable_popup: false,
        };
    },

    watch: {
        email() {
            this.error = "";
        },

        disable_popup(bool) {
            if (bool) {
                this.disableNewsletterPopup();
            } else {
                this.enableNewsletterPopup();
            }
        },
    },

    mounted() {
        setTimeout(() => {
            $(".newsletter-wrap").modal("show");
        }, 1000);
    },

    methods: {
        enableNewsletterPopup() {
            axios.post(route("storefront.newsletter_popup.store"));
        },

        disableNewsletterPopup() {
            axios.delete(route("storefront.newsletter_popup.destroy"));
        },

        subscribe() {
            if (!this.email || this.subscribed) {
                return;
            }

            this.subscribing = true;

            axios
                .post(route("subscribers.store"), {
                    email: this.email,
                })
                .then(() => {
                    this.email = "";
                    this.subscribed = true;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.error = error.response.data.errors.email[0];

                        return;
                    }

                    this.error = error.response.data.message;
                })
                .finally(() => {
                    this.subscribing = false;
                });
        },
    },
};
