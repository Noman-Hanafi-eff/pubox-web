import Admin from "@admin/js/Admin";
import md5 from "blueimp-md5";
import tinyMCE from "tinymce";
import draggable from "vuedraggable";
import Selectize from "vue2-selectize";
import flatPickr from "vue-flatpickr-component";
import FormSectionMixin from "./FormSectionMixin";
import AttributeMixin from "./AttributeMixin";
import VariationMixin from "./VariationMixin";
import VariantMixin from "./VariantMixin";
import BulkEditVariantsMixin from "./BulkEditVariantsMixin";
import OptionMixin from "./OptionMixin";
import DownloadMixin from "./DownloadMixin";
import DataTransformMixin from "./DataTransformMixin";
import { toaster } from "@admin/js/Toaster";

window.md5 = md5;
window.toaster = toaster;

export default {
    components: {
        draggable,
        Selectize,
        flatPickr,
    },

    mixins: [
        FormSectionMixin,
        AttributeMixin,
        VariationMixin,
        VariantMixin,
        BulkEditVariantsMixin,
        OptionMixin,
        DownloadMixin,
        DataTransformMixin,
    ],

    mounted() {
        this.initTinyMCE();

        window.admin = new Admin();
    },

    methods: {
        uid() {
            return Math.random().toString(36).slice(3);
        },

        focusEditor() {
            tinyMCE.get("description").focus();
        },

        focusField({ selector, key }) {
            if (key !== undefined) {
                this.errors.clear(key);
            }

            this.$nextTick(() => {
                $(`${selector}`).trigger("focus");
            });
        },

        regenerateVariationsAndVariantsUid() {
            this.regenerateVariationsUid();

            const variations = this.getFilteredVariations();
            const newVariants = this.generateNewVariants(variations);

            newVariants.forEach(({ uids }, index) => {
                this.$set(this.form.variants[index], "uid", md5(uids));
                this.$set(this.form.variants[index], "uids", uids);
            });
        },

        hasAnyError({ name, uid }) {
            return Object.keys(this.errors.errors).some((key) =>
                key.startsWith(`${name}.${uid}`)
            );
        },

        clearErrors({ name, uid }) {
            this.clearMatchedErrors(`${name}.${uid}`);
        },

        clearValuesError({ name, uid }) {
            this.clearMatchedErrors(`${name}.${uid}.values`);
        },

        clearValueRowErrors({ name, uid, valueUid }) {
            this.clearMatchedErrors(`${name}.${uid}.values.${valueUid}`);
        },

        clearMatchedErrors(str) {
            Object.keys(this.errors.errors).forEach((key) => {
                if (key.startsWith(str)) {
                    this.errors.clear(key);
                }
            });
        },

        scrollToFirstErrorField(elements) {
            this.$nextTick(() => {
                [...elements]
                    .find(
                        (el) => el.name === Object.keys(this.errors.errors)[0]
                    )
                    .focus();
            });
        },

        addMedia() {
            const picker = new MediaPicker({ type: "image", multiple: true });

            picker.on("select", ({ id, path }) => {
                this.form.media.push({
                    id: +id,
                    path,
                });
            });
        },

        removeMedia(index) {
            this.form.media.splice(index, 1);
        },

        preventLastSlideDrag(event) {
            return event.related.className.indexOf("disabled") === -1;
        },

        toggleAccordions({ selector, state, data }) {
            const event = new Event("click");
            const elements = document.querySelectorAll(selector);

            if (!state) {
                data.forEach(({ is_open }, index) => {
                    if (is_open) {
                        elements[index].dispatchEvent(event);
                    }
                });

                return;
            }

            [...elements].forEach((element) => {
                element.dispatchEvent(event);
            });
        },

        toggleAccordion(event, data) {
            const target = $(event.currentTarget);
            const panelTitle = target.find('[data-toggle="collapse"]');
            const panelBody = target.next();

            if (data.is_open) {
                panelBody.css("display", "block");
            }

            panelTitle.attr("data-transition", true);

            this.$set(data, "is_open", !data.is_open);

            panelBody.slideToggle(300, () => {
                panelTitle.attr("data-transition", false);
                panelBody.removeAttr("style");
            });
        },

        setSearchableSelectizeConfig() {
            this.searchableSelectizeConfig = {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                load: function (query, callback) {
                    var url = route("admin.products.index");

                    if (url === undefined || query.length === 0) {
                        return callback();
                    }

                    $.get(url + "?query=" + query, callback, "json");
                },
                plugins: ["remove_button"],
            };
        },

        setCategoriesSelectizeConfig() {
            this.categoriesSelectizeConfig = {
                plugins: ["remove_button"],
                delimiter: ",",
                persist: true,
                selectOnTab: true,
                hideSelected: false,
                allowEmptyOption: true,
                onItemAdd(value) {
                    this.getItem(value)[0].innerHTML = this.getItem(
                        value
                    )[0].innerHTML.replace(/¦––\s/g, "");
                },
            };
        },

        initTinyMCE() {
            tinyMCE.baseURL = `${FleetCart.baseUrl}/build/assets/tinymce`;

            tinyMCE.init({
                selector: ".wysiwyg",
                theme: "silver",
                height: 350,
                menubar: false,
                branding: false,
                image_advtab: true,
                automatic_uploads: true,
                media_alt_source: false,
                media_poster: false,
                relative_urls: false,
                toolbar_mode: "sliding", // Possible values: floating, sliding, scrolling, wrap
                directionality: FleetCart.rtl ? "rtl" : "ltr",
                cache_suffix: `?v=${FleetCart.version}`,
                plugins:
                    "lists, link, table, image, media, paste, autosave, autolink,quickbars, wordcount, code, fullscreen",
                toolbar:
                    "styleselect | bold italic underline strikethrough blockquote | bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent | forecolor removeformat | table | image media link | code fullscreen",
                quickbars_selection_toolbar:
                    "bold italic | quicklink h2 h3 blockquote quickimage quicktable",
                setup: (editor) => {
                    editor.on("change", () => {
                        editor.save();
                        editor.getElement().dispatchEvent(new Event("input"));

                        this.errors.clear("description");
                    });
                },
                images_upload_handler: (blobInfo, success, failure) => {
                    let formData = new FormData();

                    formData.append(
                        "file",
                        blobInfo.blob(),
                        blobInfo.filename()
                    );

                    $.ajax({
                        method: "POST",
                        url: route("admin.media.store"),
                        data: formData,
                        processData: false,
                        contentType: false,
                    })
                        .then((file) => {
                            success(file.path);
                        })
                        .catch((xhr) => {
                            failure(xhr.responseJSON.message);
                        });
                },
            });
        },
    },
};
