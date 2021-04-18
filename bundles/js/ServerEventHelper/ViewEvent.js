export class ViewEvent {
    type = null;
    id = null;
    trigger = null;
    target = null;
    delegate = null;
    form = null;
    path = null;
    history = false;
    deleteCache = false;

    static get TYPE_LINK() {
        return 'link';
    }

    static get TYPE_MODAL() {
        return 'modal';
    }

    static get TYPE_SUBMIT() {
        return 'submit';
    }

    static get TYPE_CALLBACK() {
        return 'callback';
    }

    /**
     *
     * @param eventData
     * @return {*}
     */
    static factory(eventData) {
        if (eventData.type) {
            switch (eventData.type) {
                case ViewEvent.TYPE_SUBMIT:
                    return this.#triggerSubmit(event);
                case ViewEvent.TYPE_CALLBACK:
                    return this.#triggerCallback(event);
                case ViewEvent.TYPE_LINK:
                    return this.#triggerLink(event);
                case ViewEvent.TYPE_MODAL:
                    return this.#triggerModal(event);
            }
        }
        throw new Error('Could not create server event');
    }
}
