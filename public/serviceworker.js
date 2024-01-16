var staticCacheName = "pwa-v" + new Date().getTime();

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();

    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            fetch("/build/manifest.json")
                .then((response) => {
                    return response.json();
                })
                .then((assets) => {
                    var filesToCache = [
                        "/offline",
                        "/build/" +
                            assets[
                                "Themes/Storefront/resources/assets/public/sass/main.scss"
                            ].file,
                        "/build/" +
                            assets[
                                "Themes/Storefront/resources/assets/public/js/main.js"
                            ].file,
                        "/pwa/icons/icon-48x48.png",
                        "/pwa/icons/icon-72x72.png",
                        "/pwa/icons/icon-96x96.png",
                        "/pwa/icons/icon-128x128.png",
                        "/pwa/icons/icon-144x144.png",
                        "/pwa/icons/icon-152x152.png",
                        "/pwa/icons/icon-192x192.png",
                        "/pwa/icons/icon-384x384.png",
                        "/pwa/icons/icon-512x512.png",
                    ];

                    return cache.addAll(filesToCache);
                });
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});
