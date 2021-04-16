self.addEventListener('fetch', event => {
    event.respondWith(async function () {
        const response = await fetch(event.request);
        if (event.clientId) {
            const client = await clients.get(event.clientId);
            if (client) {
                client.postMessage({
                    type: 'fetch',
                    response:  response.headers.get('Content-Type') === 'application/json' ? await response.json() : await response.text()
                });
            }
        }
        return response;
    });
});

