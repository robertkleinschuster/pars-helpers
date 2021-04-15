document.addEventListener("DOMContentLoaded", function (event) {
    document.querySelectorAll('.service-worker').forEach(function (element) {
        let file = element.dataset.src;
        navigator.serviceWorker.register(file, {scope: '/'}).then(function (reg) {
            reg.update();
        }).catch(function (error) {
            console.log('SW: ' + error);
        });
    });
    navigator.serviceWorker.addEventListener('message', event => {
        if (event.data.type === 'fetch') {
            fetchEvent(event);
        }
    });
    initEventListener();
});

function showOverlay()
{
    if (document.querySelectorAll('.ajax-overlay').length === 0) {
        document.querySelectorAll('body').forEach(function (element) {
            let html = '<div class="overlay text-center ajax-overlay"><div style="width: 7rem; height: 7rem;" class="spinner-grow text-light shadow-lg" role="status">\n' +
                '  <span class="sr-only">Loading...</span>\n' +
                '</div></div>';
            element.append(createElementFromHTML(html));
        });
    }
    document.querySelectorAll('.ajax-overlay').forEach(element => element.classList.add('show'));
}

function hideOveralay()
{
    document.querySelectorAll('.ajax-overlay').forEach(element => element.classList.remove('show'));
}

function initEventListener()
{
    document.querySelectorAll('[data-event]').forEach(element => {
        element.addEventListener('click', clickEvent);
    });
}

function removeEventListener()
{
    document.querySelectorAll('[data-event]').forEach(element => {
        element.removeEventListener('click', clickEvent);
    });
}

function clickEvent(event)
{
    event.preventDefault();
    showOverlay();
    removeEventListener();
    triggerEvent(JSON.parse(event.currentTarget.dataset.event));
}

function fetchEvent(event)
{
    let data = event.data.response;
    data = handleEvent(data);
    inject(data);
    initEventListener();
    hideOveralay();
}

function triggerEvent(event)
{
    fetch(event.path, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-EVENT': JSON.stringify(event)
        },
    });
}

window.addEventListener('popstate', (event) => {
    triggerEvent(event.data.event);
});

const EVENT_TYPE_LINK = 'link';

function handleEvent(data)
{
    if (data && data.event) {
        switch (data.event.type) {
            case EVENT_TYPE_LINK:
                return handleLink(data);
        }

        if (data.event.deleteCache === true) {
            window.caches.delete('pars-helper');
        }
    }
    return data;
}

function handleLink(data)
{
    if (data.event.path && data.event.target && data.html) {
        history.replaceState(data, null, data.event.path);
        data.inject.html.push({
            mode: 'replace',
            selector: data.event.target,
            html: data.html
        })
    }
    return data;
}

function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.trim();
    return div.firstChild;
}

function inject(data)
{
    if (data && data.inject) {
        if (data.inject.html) {
            data.inject.html.forEach(function (html) {
                switch (html.mode) {
                    case 'replace':
                        document.querySelectorAll(html.selector).forEach(element => {
                            element.replaceWith(createElementFromHTML(html.html));
                        });
                        break;
                    case 'append':
                        document.querySelectorAll(html.selector).forEach(element => {
                            element.append(createElementFromHTML(html.html));
                        });
                        break;
                    case 'prepend':
                        document.querySelectorAll(html.selector).forEach(element => {
                            element.prepend(createElementFromHTML(html.html));
                        });
                        break;
                }
            })
        }
        if (data.inject.script) {
            data.inject.script.forEach(function (script) {
                if (!script.unique || document.querySelectorAll('script[src=' + script.script + ']').length === 0) {
                    document.querySelectorAll('body').forEach(element => element.append(createElementFromHTML('<script src="' + script.script + '"></script>')));
                }
            });
        }
    }
    if (data && data.debug) {
        if ($('#debug').length) {
            $('#debug .modal-body').html(data.debug);
        } else {
            $('#main').prepend("<div id='debug' class='modal'><div class='modal-dialog modal-dialog-scrollable'><div class='modal-content'>" +
                " <div class=\"modal-header\">\n" +
                "        " +
                "        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" +
                "          <span aria-hidden=\"true\">&times;</span>\n" +
                "        </button>\n" +
                "      </div>" +
                "<div class=\"modal-body\"></div></div></div></div>")
            $('#debug .modal-body').html(data.debug);
        }
        $('#debug').modal();
    }
}

