/**
 * Created by aramiszrobert on 15. 03. 03..
 */
(function () {
    'use strict'

    app.controller('UserController', UserController);

    UserController.$inject = [];

    function UserController() {
        var vm = this;

        vm.comeFromUser = "User Controller comes from user s vm";

        init();
        function init() {
            console.log('Init User');
        }

    }
})();
