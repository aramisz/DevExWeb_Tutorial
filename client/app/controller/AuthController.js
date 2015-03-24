/**
 * Created by aramisz on 01/03/15.
 */
(function () {
    'use strict';

    app.controller('AuthController', AuthController);

    AuthController.$inject = ['AuthModel', '$state', 'UserService'];

    function AuthController(AuthModel, $state, UserService) {
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
                    UserService.setToken(response.result.token);
                    UserService.setUserData(response.result.user);

                    window.location = '#/';
                } else {
                    UserService.isAuth = false;
                    alert(response.error.message);
                }
            });
        }

        function logout() {
            UserService.logout();
            //window.location = '/';
        }


    }

})();