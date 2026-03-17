const CACHE_NAME = 'eat-kun-pwa-ver1.1';
const urlsToCache = [
    './',
    './index.html',
    './index.php',
    './rank.html',
    './rank.php',
    './404.html',
    './static/index.js',
    './static/index.css',
    './static/manifest.webmanifest',
    './static/manifest_ja.webmanifest',
    './static/manifest_zh.webmanifest',
    './static/manifest_zht.webmanifest',
    './static/css/LanguageDetection.css',
    './static/i18n/en.json',
    './static/i18n/ja.json',
    './static/i18n/zh.json',
    './static/i18n/zht.json',
    './static/image/ClickAfter.png',
    './static/image/ClickBefore.png',
    './static/image/ProgressiveWebApps.png',
    './static/javascript/LanguageDetection.js',
    './static/javascript/ServiceWorker.js',
    './static/music/end.mp3',
    './static/music/err.mp3',
    './static/music/tap.mp3',
    './files/css/bootstrap.min.css',
    './files/js/bootstrap.bundle.min.js',
    './files/js/createjs.min.js',
    './files/js/jsencrypt.min.js',
    './files/js/jquery.min.js'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(cache => {
            console.log('Cache turned on');
            return cache.addAll(urlsToCache);
        })
        .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Delete old cache: ', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
        .then(response => {
            if (response) {
                return response;
            }
            return fetch(event.request).then(
                response => {
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }
                    const responseToCache = response.clone();
                    caches.open(CACHE_NAME)
                        .then(cache => {
                            cache.put(event.request, responseToCache);
                        });
                    return response;
                }
            );
        })
    );
});