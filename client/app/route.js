/**
 * Created by aramiszrobert on 15. 03. 03..
 */

var appRoute = angular.module('appRoute', ['ui.router']);

appRoute.config(function ($stateProvider, $urlRouterProvider, $locationProvider) {


    $stateProvider
        .state('index', {
            url: '/',
            templateUrl: 'view/index/index.html'
        })
        .state('user', {
            url: '/profile',
            templateUrl: 'view/user/index.html'
        }).
        state('user.profile', {
            url: '/profile/{id}',
            templateUrl: 'view/user/profile.html'
        })
        .state('user.password', {
            url: '/password',
            templateUrl: 'view/user/password.html'
        });

    //$locationProvider.html5Mode(true);

    $urlRouterProvider.otherwise('/');
});

appRoute.run(function ($rootScope, $state) {
    $rootScope.$state = $state;

});