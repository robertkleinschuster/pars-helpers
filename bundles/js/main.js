document.addEventListener("DOMContentLoaded", () => initEventListeners());

const events = {
    "click": clickEvent
};

function showOverlay() {
    if (document.querySelectorAll('.ajax-overlay').length === 0) {
        const body = document.body;
        if (!body) return;
        let html = '<div class="overlay text-center ajax-overlay">' +
            '<div style="width: 7rem; height: 7rem;" class="spinner-grow text-light shadow-lg" role="status">\n' +
            '  <span class="sr-only">Loading...</span>\n' +
            '</div></div>';
        body.append(createElementFromHTML(html));
    }
    document.querySelectorAll('.ajax-overlay').forEach(element => element.classList.add('show'));
}

function hideOverlay() {
    document.querySelectorAll('.ajax-overlay').forEach(element => element.classList.remove('show'));
}

function initEventListeners() {
    document.querySelectorAll('[data-event]').forEach(element =>
        events.forEach((name, callback) => element.addEventListener(name, callback)));
}

function removeEventListeners() {
    document.querySelectorAll('[data-event]').forEach(element =>
        events.forEach((name, callback) => element.removeEventListener(name, callback)));
}

function clickEvent(event) {
    event.preventDefault();
    showOverlay();
    triggerEvent(JSON.parse(event.currentTarget.dataset.event));
}

function fetchEvent(data) {
    data = handleEvent(data);
    handleAttributes(data);
    inject(data);
    initEventListeners();
    hideOverlay();
}

function triggerEvent(event) {
    switch (event.type) {
        case EVENT_TYPE_SUBMIT:
            return triggerSubmit(event);
        case EVENT_TYPE_LINK:
            return triggerLink(event);
        case EVENT_TYPE_MODAL:
            return triggerModal(event);
    }

}

function eventFetch(url, options) {
    fetch(url, options).then(response => {
        return response.headers.get('Content-Type') === 'application/json' ? response.json() : response.text()
    }).then(data => {
        fetchEvent(data);
    }).catch(err => console.error(err));
}

function triggerSubmit(event) {
    let url = new URL(event.path, document.baseURI);
    let form = document.getElementById(event.form);
    let formData = new FormData(form);
    eventFetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-EVENT': JSON.stringify(event)
        },
        method: form.method,
        body: formData
    });
}

function triggerModal(event) {
    let url = new URL(event.path, document.baseURI);
    eventFetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-EVENT': JSON.stringify(event)
        },
    });
}

function triggerLink(event) {
    let url = new URL(event.path, document.baseURI);
    eventFetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-EVENT': JSON.stringify(event)
        },
    });
}

window.addEventListener('popstate', event =>
    triggerEvent(event.data.event)
);

const EVENT_TYPE_LINK = 'link';
const EVENT_TYPE_MODAL = 'modal';
const EVENT_TYPE_SUBMIT = 'submit';

function handleEvent(data) {
    if (data && data.event) {
        if (data.event.deleteCache === true) {
            window.caches.delete('pars-helper');
        }

        switch (data.event.type) {
            case EVENT_TYPE_LINK:
                return handleLink(data);
            case EVENT_TYPE_MODAL:
                return handleModal(data);
            case EVENT_TYPE_SUBMIT:
                return handleSubmit(data);
        }
    }
    return data;
}

function handleSubmit(data)
{
    return data;
}


function handleModal(data) {
    if (data.event.path && data.event.target && data.html) {
        if (data.event.history === true) {
            history.replaceState(data, null, data.event.path);
            history.pushState(data, null, data.event.path);
        }
        document.querySelectorAll('#ajax-modal .modal-body').forEach(body => {
            body.innerHTML = '';
            body.append(createElementFromHTML(data.html));
        });
        $('#ajax-modal').modal({backdrop: 'static', keyboard: false});
        $('#ajax-modal').on('click.closeModal', '.close-modal', function () {
            $('#ajax-modal').modal('hide');
        });
    }
    return data;
}

function handleLink(data) {
    if (data.event.path && data.event.target && data.html) {
        if (data.event.history === true) {
            history.replaceState(data, null, data.event.path);
            history.pushState(data, null, data.event.path);
        }
        data.inject.html.push({
            mode: 'replace',
            selector: data.event.target,
            html: data.html
        })
    }
    return data;
}

function createElementFromHTML(htmlString) {
    const div = document.createElement('div');
    div.innerHTML = htmlString.trim();
    return div.firstChild;
}

function handleAttributes(data) {
    if (data && data.attributes) {
        if (data.attributes.redirect_url) {
            window.location = data.attributes.redirect_url;
        }
    }
}

function inject(data) {
    if (data && data.inject) {
        if (data.inject.html) {
            data.inject.html.forEach(html => {
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
            data.inject.script.forEach(script => {
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

