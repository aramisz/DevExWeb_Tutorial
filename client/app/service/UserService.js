/**
 * Created by aramiszrobert on 15. 03. 10..
 */
'use strict';

app.service('UserService', function () {

    var data = {
        username: 'DevEx User',
        email: 'devex@helloandroid.com'
    }

    function init() {

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


    /**
     * Public methods
     */
    return {
        init: init,
        getUsername: getUsername,
        setUsername: setUsername,
        getEmail: getEmail,
        setEmail: setEmail
    }

});
