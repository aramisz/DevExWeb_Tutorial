var host = window.location.hostname;


var environment = 'development';

if (environment === 'development') {
    var Config = {
        VERSION: '0.5',
        WS_URL: 'http://devexweb/ws/',
        DEBUG: {
            enable: true
        }
    }
}

if (environment === 'testing') {
    var Config = {
        VERSION: '0.5',
        WS_URL: 'http://devexweb/ws/',
        DEBUG: {
            enable: true
        }
    }
}

if (environment === 'production') {
    var Config = {
        VERSION: '0.5',
        WS_URL: 'http://devexweb/ws/',
        AUTH_TOKEN: null,
        DEBUG: {
            enable: false
        }
    }
}