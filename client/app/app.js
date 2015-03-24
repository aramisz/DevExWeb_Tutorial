/**
 * Created by aramiszrobert on 15. 03. 03..
 */
'use strict';

var app = angular.module('app', [
    'appRoute',
    'jsonRPC'
]);

app.config(function ($httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];

    $httpProvider.interceptors.push('ErrorInterceptorService');
});

app.run(function () {
    console.log('INIT APP');
});

