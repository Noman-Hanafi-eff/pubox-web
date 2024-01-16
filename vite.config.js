import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue2";
import glob from "glob";
import copy from "rollup-plugin-copy";
import path from "path";
import autoprefixer from "autoprefixer";
import postcssRTLCSS from "postcss-rtlcss";

const FLEETCART_VERSION = "4.0.6";
const ASSET_PATHS = [
    "Modules/*/Resources/assets/admin/sass/main.scss",
    "Modules/*/Resources/assets/admin/js/main.js",
    "Modules/*/Resources/assets/admin/js/create.js",
    "Modules/*/Resources/assets/admin/js/edit.js",
    "Themes/Storefront/resources/assets/*/sass/main.scss",
    "Themes/Storefront/resources/assets/*/js/main.js",
];

export default defineConfig(({ command, mode }) => {
    return {
        plugins: [
            laravel({
                input: [
                    "resources/sass/install/main.scss",
                    "resources/js/install/main.js",
                    "Modules/Admin/Resources/assets/sass/main.scss",
                    "Modules/Admin/Resources/assets/js/main.js",
                    "Modules/Admin/Resources/assets/js/app.js",
                    "Modules/Admin/Resources/assets/sass/dashboard.scss",
                    "Modules/Admin/Resources/assets/js/dashboard.js",
                    "Modules/User/Resources/assets/admin/sass/auth.scss",
                    "Modules/User/Resources/assets/admin/js/auth.js",
                    "Modules/Order/Resources/assets/admin/sass/print.scss",
                    "Themes/Storefront/resources/assets/public/js/vendors/flatpickr.js",
                    ...glob.sync(`{${ASSET_PATHS.join(",")}}`),
                ],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            copy({
                targets: [
                    {
                        src: [
                            "resources/images/favicon.ico",
                            "node_modules/jquery/dist/jquery.min.js",
                            "Modules/Admin/node_modules/tinymce",
                            "Modules/Admin/Resources/assets/images/*",
                            "Modules/Category/node_modules/jstree/dist/jstree.min.js",
                            "Themes/Storefront/node_modules/bootstrap/dist/js/bootstrap.min.js",
                            "Themes/Storefront/node_modules/slick-carousel/slick/slick.min.js",
                            "Themes/Storefront/node_modules/countdown/countdown.min.js",
                            "Themes/Storefront/resources/assets/public/images/*",
                        ],
                        dest: "public/build/assets",
                    },
                    {
                        src: "Themes/Storefront/node_modules/line-awesome/dist/line-awesome/fonts",
                        dest: ["Themes/Storefront/resources/assets/public"],
                    },
                ],
                copyOnce: true,
                hook: command === "build" ? "writeBundle" : "buildStart",
            }),
        ],
        css: {
            postcss: {
                plugins: [
                    autoprefixer(),
                    postcssRTLCSS({
                        ltrPrefix: ".ltr",
                        rtlPrefix: ".rtl",
                        processKeyFrames: true,
                    }),
                ],
            },
        },
        resolve: {
            alias: {
                vue: path.resolve(
                    __dirname,
                    "./node_modules/vue/dist/vue.esm.js"
                ),
                "@admin": path.resolve(
                    __dirname,
                    "./Modules/Admin/Resources/assets"
                ),
                "@modules": path.resolve(__dirname, "./Modules"),
            },
        },
        build: {
            sourcemap: mode === "production",
            chunkSizeWarningLimit: 1000,
            rollupOptions: {
                output: {
                    globals: {
                        jquery: "jQuery",
                    },
                    entryFileNames: `assets/[name]-[hash]-v${FLEETCART_VERSION}.js`,
                    chunkFileNames: `assets/[name]-[hash]-v${FLEETCART_VERSION}.js`,
                    assetFileNames: function () {
                        return `assets/[name]-[hash]-v${FLEETCART_VERSION}.[ext]`;
                    },
                },
            },
        },
    };
});
