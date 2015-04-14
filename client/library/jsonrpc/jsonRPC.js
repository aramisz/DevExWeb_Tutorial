'use strict';

var jsonRPC = angular.module('jsonRPC', []);

jsonRPC.provider('$jsonRPC', function () {

    this.options = {
        url: null,
        headers: {},
        secret: false
    };

    this.$get = function () {
        var options = this.options;

        return {
            getUrl: function () {
                return options.url;
            },
            getHeaders: function () {
                return options.headers;
            },
            getSecret: function () {
                return options.secret;
            }
        };
    };

    this.setUrl = function (url) {
        this.options.url = url;
    };

    this.setHeaders = function (headers) {
        this.options.headers = headers;
    };

    this.setSecret = function (secret) {
        this.options.secret = secret;
    };

});

jsonRPC.service('jsonRPCService', function ($http, $jsonRPC) {
    this.defaults = {
        version: '2.0',
        url: $jsonRPC.getUrl(),
        headers: $jsonRPC.getHeaders(),
        secret: $jsonRPC.getSecret()
    };

    this.setUrl = function (url) {
        this.defaults.url = url;
    };

    this.setHeaders = function (headers) {
        var default_headers = this.defaults.headers;

        this.defaults.headers = angular.extend(default_headers, headers);
    };

    this.setSecret = function (secret) {
        this.defaults.secret = secret;
    };

    this.call = function (namespace, method, params, id) {
        if (params === undefined) {
            params = {};
        }

        if (id === undefined) {
            id = window.Date.now();
        }

        // make request
        var bodyRequest = JSON.stringify({
            'jsonrpc': this.defaults.version,
            'method': method,
            'params': params,
            'id': id
        });

        var secret = this.defaults.secret;

        var url = this.defaults.url.replace(/\/+$/, '') + '/' + namespace.replace(/^\/+/, '');
        var request = {
            'url': url,
            'method': 'POST',
            'data': bodyRequest,
            'headers': this.defaults.headers
        };

        var promise = $http(request).then(function (result) {

            var return_data = [];

            if (result.status === 200) {

                if (secret) {
                    var data = JSON.parse(Base64.decode(result.data));
                } else {
                    var data = result.data;
                }

                if (data.result !== undefined) {
                    return_data = data.result;
                }

                if (data.error !== undefined) {
                    return_data = data;
                }
            }

            return return_data;

        });

        return promise;
    };
});