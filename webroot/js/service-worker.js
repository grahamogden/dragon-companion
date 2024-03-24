const VERSION = '2024-01-14-1';
const CACHE_NAME = `dragon-companion-${VERSION}`;

const APP_STATIC_RESOURCES = [
    '/combat-encounters',
    '/js/dist/combatEncounters.bundle.js',
    '/css/main.css',
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            cache.addAll(APP_STATIC_RESOURCES);
        })(),
    );
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        (async () => {
            const names = await caches.keys();
            await Promise.all(
                names.map((name) => {
                if (name !== CACHE_NAME) {
                    return caches.delete(name);
                }
                }),
            );

            await clients.claim();
        })(),
    );
});
  