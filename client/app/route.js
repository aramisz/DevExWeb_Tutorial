/**
 * Created by aramiszrobert on 15. 03. 03..
 */

var appRoute = angular.module('appRoute', ['ui.router']);

appRoute.config(function ($stateProvider, $urlRouterProvider, $locationProvider) {


    $stateProvider
        .state('index', {
            url: '/',
            templateUrl: 'view/about/about-index.html'
        })
        .state('about', {
            url: '/about',
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
        })
        .state('auth', {
            url: '/auth',
            abstract: true,
            templateUrl: 'view/auth/auth-index.html'
        })
        .state('auth.login', {
            url: '/login',
            templateUrl: 'view/auth/auth-login.html'
        })
        .state('auth.logout', {
            url: '/logout',
            templateUrl: 'view/auth/auth-login.html',
            data: {pageTitle: 'Logout'}
        });

    //$locationProvider.html5Mode(true);

    $urlRouterProvider.otherwise('/');
});

appRoute.run(function ($rootScope, $state) {
    $rootScope.$state = $state;

});