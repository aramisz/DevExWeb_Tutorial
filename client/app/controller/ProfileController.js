/**
 * Created by aramiszrobert on 15. 03. 03..
 */
(function () {
    'use strict'

    app.controller('ProfileController', ProfileController);

    ProfileController.$inject = ['$state', '$stateParams', 'UserService'];

    function ProfileController($state, $stateParams, UserService) {
        var vm = this;

        vm.saveForm = saveForm;
        vm.user = {};


        init();
        function init() {
            console.log('Init Profile');

            var params = $stateParams;
            console.log('STATE PARAMS', params.id);


            vm.user.username = UserService.getUsername();
            vm.user.email = UserService.getEmail();
        }

        function saveForm() {
            UserService.setUsername(vm.user.username);
            UserService.setEmail(vm.user.email);

            console.log(vm.user);

            // TODO: refresh mainCtrl
        }

    }
})();
