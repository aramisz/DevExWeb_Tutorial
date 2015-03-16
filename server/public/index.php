<?php

error_reporting(E_ALL);

//Time constants
defined('TIME_MINUTE') || define('TIME_MINUTE', 60);
defined('TIME_HOUR') || define('TIME_HOUR', 3600);
defined('TIME_DAY') || define('TIME_DAY', 86400);
defined('TIME_WEEK') || define('TIME_WEEK', 604800);
defined('TIME_YEAR') || define('TIME_YEAR', 31536000);
defined('APP_PATH') || define('APP_PATH', dirname(__FILE__) . '/../app');

//API KEY
defined('API_KEY') || define('API_KEY', 'Delorean');
defined('TOKEN_EXPIRATION') || define('TOKEN_EXPIRATION', TIME_DAY);                  // seconds
defined('TOKEN_NOT_BEFORE_VALID') || define('TOKEN_NOT_BEFORE_VALID', time());

error_reporting(E_ALL);

defined('APP_PATH') || define('APP_PATH', dirname(__FILE__) . '/../app');
defined('WEB_PATH') || define('WEB_PATH', dirname(__FILE__));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production');

try {

    /**
     * Read the configuration
     */
    $config = new \Phalcon\Config\Adapter\Ini(__DIR__ . "/../app/config/config." . APPLICATION_ENV . ".ini");

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
