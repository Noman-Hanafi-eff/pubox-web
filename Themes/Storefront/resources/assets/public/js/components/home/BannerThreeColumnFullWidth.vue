<template>
    <section
        class="banner-wrap three-column-full-width-banner padding-tb-75"
        :style="'background-image: url(' + data['background'].image.path + ')'"
    >
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a
                        :href="data.banner_1.call_to_action_url"
                        class="banner"
                        :target="
                            data.banner_1.open_in_new_window
                                ? '_blank'
                                : '_self'
                        "
                    >
                        <img :src="data.banner_1.image.path" alt="Banner" />
                    </a>
                </div>

                <div class="col-md-10">
                    <a
                        :href="data.banner_2.call_to_action_url"
                        class="banner"
                        :target="
                            data.banner_2.open_in_new_window
                                ? '_blank'
                                : '_self'
                        "
                    >
                        <img :src="data.banner_2.image.path" alt="Banner" />
                    </a>
                </div>

                <div class="col-md-4">
                    <a
                        :href="data.banner_3.call_to_action_url"
                        class="banner"
                        :target="
                            data.banner_3.open_in_new_window
                                ? '_blank'
                                : '_self'
                        "
                    >
                        <img :src="data.banner_3.image.path" alt="Banner" />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ["data"],
};
</script>
