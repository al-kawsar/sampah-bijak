self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('your-app-cache').then((cache) => {
            return cache.addAll([
                '/',
                '/offline.html',
                '/images/192.png',
                '/images/512.png',
                // tambahkan asset lain yang perlu di-cache
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request).catch(() => {
                    if (event.request.mode === 'navigate') {
                        return caches.match('/offline.html');
                    }
                });
            })
    );
});
