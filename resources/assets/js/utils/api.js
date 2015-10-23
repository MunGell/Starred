import $ from 'jquery'
import Cookies from '../utils/cookies'

function Api() {
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': Cookies.getCookie('XSRF-TOKEN')
        }
    });
}

Api.prototype.get = function (url, callback) {
    $.get(url)
        .done(callback)
        .fail(this._onError);
};

Api.prototype.post = function (url, data, callback) {
    $.post(url, data)
        .done(callback)
        .fail(this._onError);
};

Api.prototype.getRepository = function (id, callback) {
    this.get('/repositories/' + id, callback);
};

Api.prototype.addTag = function (id, data, callback) {
    this.post('/repositories/' + id + '/tags/add', data, callback);
};

Api.prototype.removeTag = function (id, data, callback) {
    this.post('/repositories/' + id + '/tags/remove', data, callback);
};

Api.prototype.search = function(keyword, page, callback) {
    page = page || 1;
    this.get('/search/' + encodeURIComponent(keyword) + '?page=' + page, callback)
};

Api.prototype.checkQueue = function(callback) {
    this.get('/sync/queue', callback);
};

Api.prototype._onError = function(response) {
    if (response.status === 401) {
        // @todo: add return url in here
        window.location = '/auth/login';
    }
};

export default new Api();