class Parameter {
    attributes;
    name;

    constructor(name) {
        this.attributes = [];
        this.name = name;
    }

    setAttributes(key, value = '') {
        this.attributes.push({
            key: key,
            value: value
        });
        return this;
    }

    fromString(data) {
        let that = this;
        data = decodeURIComponent(data);
        data.split(';').forEach(item => {
            let key = item.split(':')[0];
            let value = item.split(':')[1];
            if (typeof value !== 'undefined' && value.length) {
                that.setAttributes(key, value);
            } else {
                that.setAttributes(key);
            }
        });
        return this;
    }

    toString() {
        let str = '';
        let length = this.attributes.length;
        this.attributes.forEach((item, index) => {
                if (item.value.length) {
                    str += item.key + ':' + item.value;
                    if (index <= length - 2) {
                        str += ';';
                    }
                } else {
                    str += item.key;
                }
            }
        )
        return encodeURIComponent(str);
    }
}

class PathHelper {
    base;
    parameters;

    constructor() {
        let that = this;
        this.parameters = [];
        this.base = window.location.pathname;
        let search = window.location.search;
        if (search.length) {
            search = search.substring(1);
            search.split('&').forEach(part => {
                let name = part.split('=')[0]
                let parameterStr = part.split('=')[1];
                if (parameterStr.length) {
                    let param = new Parameter(name);
                    param.fromString(parameterStr);
                    that.parameters.push(param);
                }
            });
        }
    }

    addParameter(parameter) {
        this.parameters = this.parameters.filter(item => item.name !== parameter.name);
        this.parameters.push(parameter);
    }

    getPath() {
        let str = '?';
        let length = this.parameters.length;
        this.parameters.forEach((param, index) => {
            str += param.name + '=' + param.toString();
            if (index <= length - 2) {
                str += '&';
            }
        });
        return str;
    }
}
