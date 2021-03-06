'use strict';

app.service('RpcService', function (jsonRPCService, UserService) {

    return {
        call: function (namespace, method, params, cache) {
            if (cache === undefined) {
                cache = true;
            }

            jsonRPCService.setUrl(Config.WS_URL);
            jsonRPCService.setSecret(Config.SECRET);

            jsonRPCService.setHeaders({
                'Content-Type': 'application/x-www-form-urlencoded',
                'auth-token': 'no'
            });

            if (UserService.isAuth) {
                jsonRPCService.setHeaders({
                    'auth-token': UserService.getToken()
                });
            }

            if (Config.WS_AUTHORIZATION_REQUIRED) {
                jsonRPCService.setHeaders({
                    //'Authorization': 'Basic ' + btoa(Config.WS_AUTHORIZATION_USERNAME + ":" + Config.WS_AUTHORIZATION_PASSWORD)
                });
            }

            var result = jsonRPCService.call(namespace, method, params, cache);
            return result;
        }
    };
});

