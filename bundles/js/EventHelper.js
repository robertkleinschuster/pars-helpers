import {OverlayHelper} from "./OverlayHelper";
import {HtmlHelper} from "./HtmlHelper";

const EVENT_TYPE_LINK = 'link';
const EVENT_TYPE_MODAL = 'modal';
const EVENT_TYPE_SUBMIT = 'submit';
const EVENT_TYPE_CALLBACK = 'callback';

export class EventHelper {
    constructor(root) {
        this.overlay = new OverlayHelper();
        this.root = root;
    }

    init() {
        this.root.querySelectorAll('[data-event]').forEach(this.attatchEvents.bind(this));
    }

    attatchEvents(element) {
        if (element && element.matches('[data-event]')) {
            let serverEvent = JSON.parse(element.dataset.event);
            console.debug('Attatched event: ', serverEvent);
            this.triggerListener = (event) => {
                if (serverEvent.delegate === null || event.target.closest(serverEvent.delegate)) {
                    event.preventDefault();
                    this.triggerEvent(serverEvent);
                }
            }
            element.removeEventListener(serverEvent.trigger, this.triggerListener);
            element.addEventListener(serverEvent.trigger, this.triggerListener.bind(this));
        }
    }

    triggerEvent(event) {
        console.debug('Triggered event: ', event)
        switch (event.type) {
            case EVENT_TYPE_SUBMIT:
                return this.triggerSubmit(event);
            case EVENT_TYPE_CALLBACK:
            case EVENT_TYPE_LINK:
                return this.triggerLink(event);
            case EVENT_TYPE_MODAL:
                return this.triggerModal(event);
        }
    }

    triggerSubmit(event) {
        let url = new URL(event.path, document.baseURI);
        let form = document.getElementById(event.form);
        let formData = new FormData(form);
        this.fetchEvent(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-EVENT': JSON.stringify(event)
            },
            method: form.method,
            body: formData
        });
    }

    triggerModal(event) {
        let url = new URL(event.path, document.baseURI);
        this.fetchEvent(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-EVENT': JSON.stringify(event)
            },
        });
    }

    triggerLink(event) {
        let url = new URL(event.path, document.baseURI);
        this.fetchEvent(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-EVENT': JSON.stringify(event)
            },
        });
    }

    fetchEvent(url, options) {
        if (!this.overlay.isVisible()) {
            this.overlay.show();
            fetch(url, options)
                .then(response => response.headers.get('Content-Type') === 'application/json' ? response.json() : response.text())
                .then(data => {
                    this.handleEvent(data)
                    this.inject(data);
                    this.handleAttributes(data);
                    this.overlay.hide();
                })
                .catch(err => console.error(err))
        }
    }


    handleEvent(data) {
        if (data && data.event) {
            if (data.event.deleteCache === true) {
                window.caches.delete('pars-helper');
            }
            switch (data.event.type) {
                case EVENT_TYPE_MODAL:
                case EVENT_TYPE_LINK:
                    return this.handleLink(data);
                case EVENT_TYPE_MODAL:
                    return this.handleModal(data);
                case EVENT_TYPE_SUBMIT:
                    return this.handleSubmit(data);
                case EVENT_TYPE_CALLBACK:
                    return this.handleCallback(data);
            }
        }
        return data;
    }

    handleSubmit(data) {
        return data;
    }

    handleCallback(data) {
        if (data.event.path && data.event.target && data.html) {
            data.inject.html.push({
                mode: 'replace',
                selector: data.event.target,
                html: data.html
            })
        }
        return data;
    }


    handleModal(data) {
        if (data.event.path && data.event.target && data.html) {
            if (data.event.history === true) {
                history.replaceState(data, null, data.event.path);
                history.pushState(data, null, data.event.path);
            }
            document.querySelectorAll('#ajax-modal .modal-body').forEach(body => {
                body.innerHTML = '';
                body.append(HtmlHelper.createElementFromHTML(data.html));
            });
            // todo open modal
        }
        return data;
    }

    handleLink(data) {
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

    handleAttributes(data) {
        if (data && data.attributes) {
            if (data.attributes.redirect_url) {
                window.location = data.attributes.redirect_url;
            }
        }
    }

    inject(data) {
        if (data && data.inject) {
            if (data.inject.html) {
                data.inject.html.forEach(html => {
                    document.querySelectorAll(html.selector).forEach(element => {
                        const newElement = HtmlHelper.createElementFromHTML(html.html);
                        switch (html.mode) {
                            case 'replace':
                                element.replaceWith(newElement);
                                break;
                            case 'append':
                                element.append(newElement);
                                break;
                            case 'prepend':
                                element.prepend(newElement);
                                break;
                        }
                        if (newElement.matches('[data-event]')) {
                            this.attatchEvents(newElement);
                        }
                        newElement.querySelectorAll('[data-event]').forEach(newSubElement => {
                                this.attatchEvents(newSubElement);
                            }
                        );
                    });
                })
            }
            if (data.inject.script) {
                data.inject.script.forEach(script => {
                    if (!script.unique || document.querySelectorAll('script[src=' + script.script + ']').length === 0) {
                        document.querySelectorAll('body').forEach(element => element.append(HtmlHelper.createElementFromHTML('<script src="' + script.script + '"></script>')));
                    }
                });
            }
        }
    }
}
