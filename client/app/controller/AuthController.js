/**
 * Created by aramisz on 01/03/15.
 */
(function () {
    'use strict';

    app.controller('AuthController', AuthController);

    AuthController.$inject = ['$rootScope', 'AuthModel', '$state', 'UserService'];

    function AuthController($rootScope, AuthModel, $state, UserService) {
        var vm = this;

        vm.login = login;
        vm.logout = logout;

        init();

        function init() {
            console.log('AuthController INIT', $state.current.name);

            if ($state.current.name === 'auth.logout') {
                logout();
            }
        }

        function login(user) {

            AuthModel.login(user.email, user.password).then(function (response) {

                console.log('RESPONSE', response);

                if (!angular.isDefined(response.error)) {

                    UserService.isAuth = true;
                    UserService.setToken(response.token);
                    UserService.setUserData(response.user);

                    $rootScope.$broadcast('userAuth', {
                        isAuth: true,
                        userData: response.user
                    });

                    window.location = '#/';
                } else {
                    UserService.isAuth = false;
                    alert(response.error.message);
                }
            });
        }

        function logout() {
            $rootScope.$broadcast('userAuth', {
                isAuth: false,
                userData: {}
            });

            console.log('LOGOUT');

            UserService.logout();
            //window.location = '/';
        }


    }

})();