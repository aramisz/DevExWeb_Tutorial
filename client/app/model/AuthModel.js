'use strict';

app.service('AuthModel', function ($http, RpcService) {

    return {
        login: function (email, password) {
            return RpcService.call('', 'User/UserAuthService::login', {'email': email, 'password': password});
        },

        getUserByToken: function (token) {
            return RpcService.call('', 'User/UserAuthService::getUserByToken', {'token': token});
        }
    }
});
