'use strict';

//app.controller('ErrorCtrl', function ($scope) {
//
//});

app.factory('ErrorInterceptorService', function ($q, $location, $window) {
    return {
        request: function (config) {
            return config || $q.when(config);
        },
        response: function (response) {

            if (response.status == 200) {
                console.log('200 OK');
            }

            return response || $q.when(response);
        },
        responseError: function (response) {

            if (response.status !== 200) {

                /**
                 * Login user
                 */
                if (response.status == 402) {

                    alert(response.data.error.message + ' (ErrorService)');
                }

                /**
                 * Token error
                 */
                if (response.status == 403) {
                    alert(response.data.error.message + ' (ErrorService)');
                }

                /**
                 * Not found
                 */
                if (response.status == 404) {

                }

            } else {
                console.log('Other fail status', response.status);
            }

            return $q.reject(response);
        }
    };
});
