/**
 * Created by aramiszrobert on 15. 03. 03..
 */
(function () {
    'use strict'

    app.controller('MainController', MainController);

    MainController.$inject = ['$rootScope', 'UserService', 'AuthModel'];

    function MainController($rootScope, UserService, AuthModel) {
        var vm = this;  // ViewModel

        vm.userData = {};
        vm.isAuth = false;

        init();
        function init() {
            console.log('Init Main');

            checkUser();

            // Getting message from ProfileController
            $rootScope.$on('update_user', function (event, user) {
                console.log('User', user);
            });

            $rootScope.$on('userAuth', function (event, userAuth) {
                console.log('userAuth', userAuth);
                vm.isAuth = userAuth.isAuth;
                vm.userData = userAuth.userData
            });

        }

        function checkUser() {
            var token = UserService.getToken();

            if (angular.isDefined(token) && token != null) {
                AuthModel.getUserByToken(token).then(function (response) {
                    if (!angular.isDefined(response.error)) {

                        UserService.isAuth = true;
                        UserService.setToken(response.token);
                        UserService.setUserData(response.user);

                        vm.userData = UserService.getUserData();
                        vm.isAuth = true;

                        console.log('USER', vm.userData);

                    } else {
                        UserService.isAuth = false;
                    }
                });
            } else {
                UserService.isAuth = false;
               window.location = '#/';
            }
        }

    }
})();

