class ElementHelper {
    /**
     *
     * @type HTMLElement
     */
    _element = null;

    /**
     *
     * @type {[]}
     */
    static listener = [];

    /**
     *
     * @param element
     */
    constructor(element)
    {
        if (typeof element === 'string' || element instanceof String) {
            this._element = document.querySelector(element);
        } else if (typeof element === 'object') {
            this._element = element;
        }
    }

    /**
     *
     * @param callback
     */
    ready(callback)
    {
        return this.on('DOMContentLoaded', callback);
    }

    /**
     *
     * @param selector
     * @return {*}
     */
    find(selector)
    {
        let elem = this.element.querySelector(selector);
        if (elem) {
            return new ElementHelper(elem);
        }
        return null;
    }

    /**
     *
     * @param cssClass
     * @return {boolean}
     */
    hasClass(cssClass)
    {
        return this.element.classList.contains(cssClass);
    }

    /**
     *
     * @param attribute
     * @return {*}
     */
    hasAttribute(attribute)
    {
        return this.element.hasAttribute(attribute);
    }

    /**
     *
     * @param attribute
     * @return {*}
     */
    getAttribute(attribute)
    {
        return this.element.getAttribute(attribute);
    }


    /**
     *
     * @param attribute
     * @param value
     * @return {*}
     */
    setAttribute(attribute, value)
    {
        return this.element.setAttribute(attribute, value);
    }


    /**
     *
     * @param cssClass
     * @return {ElementHelper}
     */
    removeClass(cssClass)
    {
        this.element.classList.remove(cssClass);
        return this;
    }

    /**
     *
     * @param cssClass
     * @return {ElementHelper}
     */
    addClass(cssClass)
    {
        this.element.classList.add(cssClass);
        return this;
    }

    /**
     *
     * @param event
     * @param callbackOrSelector
     * @param callback
     * @param once
     */
    on(event, callbackOrSelector, callback = null, once = false)
    {
        if (!Array.isArray(ElementHelper.listener[event])) {
            ElementHelper.listener[event] = [];
        }
        if (typeof callbackOrSelector == "string") {
            let length = ElementHelper.listener[event].length;
            ElementHelper.listener[event][length] = callback;
            let e = event.split('.')[0];
            this.element.addEventListener(e, function (a) {
                let closest = a.target.closest(callbackOrSelector);
                if (closest && !a.suppress) {
                    let b = new a.constructor(a.type, a);
                    callback.call(closest, b);
                }
            }, {once: once});
        } else if (typeof callbackOrSelector == 'function') {
            let length = ElementHelper.listener[event].length;
            ElementHelper.listener[event][length] = callbackOrSelector;
            let e = event.split('.')[0];
            this.element.addEventListener(e, callbackOrSelector, {once: once});
        }
        return this;
    }

    /**
     *
     * @param event
     * @param callbackOrSelector
     * @param callback
     * @return {ElementHelper}
     */
    once(event, callbackOrSelector, callback = null)
    {
        return this.on(event, callbackOrSelector, callback, true);
    }

    /**
     *
     * @param event
     */
    off(event)
    {
        if (Array.isArray(ElementHelper.listener[event])) {
            let that = this;
            let e = event.split('.')[0];
            ElementHelper.listener[event].forEach(function (callback) {
                that.element.removeEventListener(e, callback);
            });
            ElementHelper.listener[event] = [];
        }
    }

    /**
     *
     * @return {*}
     */
    get element()
    {
        return this._element;
    }
}

/**
 *
 * @type {function(*=): ElementHelper}
 */
window.element = element = window.el = el = function (element) {
    return new ElementHelper(element);
}

