/**
 * Created by aramiszrobert on 15. 03. 03..
 */
(function () {
    'use strict'

    app.controller('MainController', MainController);

    MainController.$inject = ['$rootScope', 'UserService'];

    function MainController($rootScope, UserService) {
        var vm = this;  // ViewModel

        vm.userData = UserService.getUserData();

        init();
        function init() {
            console.log('Init Main');

            // Getting message from ProfileController
            $rootScope.$on('update_user', function(event, user) {
               console.log('User', user);
            });

        }

    }
})();

