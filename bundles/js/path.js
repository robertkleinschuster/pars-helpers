class Parameter {
    attributes;
    name;

    constructor(name) {
        this.attributes = [];
        this.name = name;
    }

    setAtttribute(key, value = '') {
        this.attributes.push({
            key: key,
            value: value
        });
        return this;
    }

    fromString(data) {
        let that = this;
        data.split(';').forEach(function (item) {
            let key = item.split(':')[0];
            let value = item.split(':')[1];
            if (typeof value !== 'undefined' && value.length) {
                that.setAtttribute(key, value);
            } else {
                that.setAtttribute(key);
            }
        });
        return this;
    }

    toString() {
        let str = '';
        let length = this.attributes.length;
        this.attributes.forEach(function (item, index) {
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
            search.split('&').forEach(function (part) {
                part = decodeURIComponent(part);
                let name = part.split('=')[0]
                let paremterStr = part.split('=')[1];
                if (paremterStr.length) {
                    let param = new Parameter(name);
                    param.fromString(paremterStr);
                    that.parameters.push(param);
                }
            });
        }
    }

    addParamter(paramter) {
        this.parameters = this.parameters.filter(function (item, index) {
            return item.name !== paramter.name;
        });
        this.parameters.push(paramter);
    }

    getPath() {
        let str = '?';
        let length = this.parameters.length;
        this.parameters.forEach(function (param, index) {
            str += param.name + '=' + param.toString();
            if (index <= length - 2) {
                str += '&';
            }
        });
        return str;
    }
}
