self.addEventListener('fetch', event => {

    async function fetchWithCache() {
        const cache = await caches.open('pars-helper');
        let response = await cache.match(event.request);
        if (response) {
            event.waitUntil(cache.add(event.request));
        } else {
            response = fetch(event.request);
        }
        return response;
    }

    event.waitUntil(async function () {
        if (event.clientId) {
            const client = await clients.get(event.clientId);
            const response = fetchWithCache();
            if (client) {
                response
                    .then(response => {
                        if (response.headers.get('Content-Type') === 'application/json') {
                            return response.json()
                        } else {
                            return response.text()
                        }
                    }).then(data => {
                        client.postMessage({
                            type: 'fetch',
                            response: data
                        });
                    });
            }
        }
    }());

    event.respondWith(fetchWithCache());

});

