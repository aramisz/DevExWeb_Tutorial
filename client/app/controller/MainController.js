/**
 * Created by aramiszrobert on 15. 03. 03..
 */
(function () {
    'use strict'

    app.controller('MainController', MainController);

    MainController.$inject = ['$scope', 'UserService'];

    function MainController($scope, UserService) {
        var vm = this;

        vm.username = UserService.getUsername();

        init();
        function init() {
            console.log('Init Main');

        }

    }
})();
