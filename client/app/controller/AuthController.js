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
                if (angular.isDefined(response.success) && response.success) {

                    UserService.isAuth = true;
                    UserService.setToken(response.data.token);
                    UserService.setUserData(response.data.user);

                    window.location = '#/';
                } else {
                    UserService.isAuth = false;
                    alert('Login fail!');
                }
            });
        }

        function logout() {
            UserService.logout();
            //window.location = '/';
        }


    }

})();