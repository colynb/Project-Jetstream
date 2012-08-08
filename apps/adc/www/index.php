<?php

namespace jetstream\core;

define('APP_CACHE_ID', '1234567b');

define('DS', DIRECTORY_SEPARATOR);
define('FRAMEWORK_PARENT', realpath('../../../..'));
define('FRAMEWORK_PATH', realpath('../../..'));
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SYSTEM_APP_PATH', FRAMEWORK_PATH . DS . 'apps' . DS . 'system');
define('APP_PATH', realpath('..'));
define('APP_CACHE_PATH', FRAMEWORK_PARENT . DS . 'cache');
define('CORE_PATH', FRAMEWORK_PATH . DS . 'core' );
define('WEB_STATIC_PATH', '/static/' . APP_CACHE_ID);


/**
 * Initiaize app
 */
include APP_PATH . DS . 'config/init.php';

/**
 * Parse the request and prepare the final response for output
 */
echo System::run(System::request());



