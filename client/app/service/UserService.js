/**
 * Created by aramiszrobert on 15. 03. 10..
 */
'use strict';

app.service('UserService', function () {

    var isAuth = false;
    var token;
    var data = {
        username: 'DevEx User',
        email: 'devex@helloandroid.com'
    };

    function init() {

    }

    function getUserData() {
        return data;
    }

    function setUserData(user_data) {
        data = user_data;
    }

    function getUsername() {
        return data.username;
    }

    function setUsername(username) {
        data.username = username;
    }

    function getEmail() {
        return data.email;
    }

    function setEmail(email) {
        data.email = email;
    }

    function setToken(user_token) {
        token = user_token
        console.log('token', token);
        window.localStorage.setItem('token')
    }

    function getToken() {
        token = window.localStorage.getItem('token');
        return token;
    }

    function logout() {
        isAuth = false;
        setUser(null);
        setToken(null);
        StorageService.clearAll();
    }


    /**
     * Public methods
     */
    return {
        init: init,
        isAuth: isAuth,
        getUsername: getUsername,
        setUsername: setUsername,
        getEmail: getEmail,
        setEmail: setEmail,
        getUserData: getUserData,
        setUserData: setUserData,
        setToken: setToken,
        getToken: getToken,
        logout: logout
    }

});
