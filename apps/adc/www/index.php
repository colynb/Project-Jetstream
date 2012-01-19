<?php

namespace jetstream\core;

define('APP_BUILD_ID', $_SERVER['REDIRECT_APP_BUILD_ID']);
define('APP_CACHE_ID', '1234567b');

define('DS', DIRECTORY_SEPARATOR);
define('FRAMEWORK_PARENT', realpath('../../../..'));
define('FRAMEWORK_PATH', realpath('../../..'));
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('APP_PATH', realpath('..'));
define('APP_BUILD_PATH', APP_PATH . DS . 'builds' . DS . APP_BUILD_ID);
define('APP_CACHE_PATH', FRAMEWORK_PARENT . DS . 'cache');
define('CORE_PATH', FRAMEWORK_PATH . DS . 'core' );
define('WEB_STATIC_PATH', '/static/' . APP_BUILD_ID . '-' . APP_CACHE_ID);


/**
 * Initiaize app
 */
include APP_BUILD_PATH . DS . 'config/init.php';

/**
 * Parse the request and prepare the final response for output
 */
echo System::run(System::request());



