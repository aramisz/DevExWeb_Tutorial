'use strict';

app.service('AuthService', function (localStorageService) {
    var userIsAuthenticated = false;
    var storageName = 'usr';


    this.setUserAuthenticated = function (value) {
        userIsAuthenticated = value;
    };

    this.getUserAuthenticated = function () {

        if (this.getToken()) {
            userIsAuthenticated = true;
        } else {
            userIsAuthenticated = false;
        }

        return userIsAuthenticated;
    };

    this.getUser = function () {
        if (this.getUserAuthenticated()) {
            return localStorageService.get(storageName);
        } else {
            return null;
        }
    };

    this.setUser = function (data) {
        localStorageService.set(storageName, JSON.stringify(data));
    };

    this.setToken = function (token) {
        localStorageService.set('token', token);
    };

    this.getToken = function () {
        if (localStorageService.get('token') != undefined) {
            return localStorageService.get('token');
        } else {
            return null;
        }
    };

    this.getUserField = function (field) {
        if (this.getUserAuthenticated()) {
            var user = (localStorageService.get(storageName));
            if (user[field]) {
                return user[field];
            } else {
                return null;
            }
        } else {
            return null;
        }
    };

    /**
     * @deprecated
     * @returns {*}
     */
    this.getRole = function () {
        if (this.getUserAuthenticated()) {
            var user = (localStorageService.get(storageName));
            return user['role_id'];
        } else {
            return 'guest';
        }
    };

    this.generatePassword = function (length) {
        length = length || 5;
        return Math.random().toString(36).slice(-(length));
    };

    /**
     * Delete user
     */
    this.deleteUser = function () {

        localStorageService.remove('token');
        localStorageService.remove(storageName);
        localStorageService.clearAll();

    };

    /**
     * Logout
     */
    this.logout = function () {
        this.deleteUser();
    };

});