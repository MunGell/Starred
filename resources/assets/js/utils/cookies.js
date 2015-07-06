export default {
    getCookie: function(name) {
        return this._extractValue(name, document.cookie);
    },

    setCookie: function(name, value, days) {
        document.cookie = this._prepareValue(name, value, days);
    },

    deleteCookie: function(name) {
        this.setCookie(name, '', -1);
    },

    _extractValue: function(name, data) {
        var namePattern = name + '=',
            dataParts = data.split(';'),
            result = null,
            part;

            for (var id in dataParts) {
            part = dataParts[id].trim();
            if (part.indexOf(namePattern) === 0) {
                result = decodeURIComponent(part.substring(namePattern.length, part.length));
            }
        }

        return result;
    },

    _prepareValue: function(name, value, days, path, domain) {
        path = path || null;
        domain = domain || null;

        value = encodeURIComponent(value);

        var expirePart = '',
            domainPart = '',
            pathPart = '';

        if (days) {
            expirePart = '; expires=' + (new Date(Date.now() + (days * 24 * 60 * 60 * 1000))).toUTCString();
        }

        if (path) {
            pathPart = '; path=' + path;
        }

        if (domain) {
            domainPart = '; domain=' + domain;
        }

        return name + '=' + value + expirePart + pathPart + domainPart;
    }
};