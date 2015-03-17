'use strict';

app.service('UserModel', function ($http, RpcService) {

    return {
        getUserProfile: function () {
            return RpcService.call('', 'User/UserService::getUserProfile', {});
        },
        getCompanyUsers: function (company_id) {
            return RpcService.call('', 'User/UserService::getUsersByCompanyId', {'company_id': company_id});
        },
        addUser: function (user) {
            return RpcService.call('', 'User/UserService::addUser', {'user_data': user});
        },
        saveProfile: function (profile) {
            return RpcService.call('', 'User/UserService::saveProfile', {'user_profile': profile});
        }
    }
});
