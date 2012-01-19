<?php

use jetstream\core\System;



$env = $_SERVER['APP_ENVIRONMENT'];

if ( $env == 'production' ) {
	$error_level = 0;
	$debug = false;
} else {
	$error_level = E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR;
	$debug = true;
}

$path = array(
	'framework' => FRAMEWORK_PATH,
	'core' => CORE_PATH,
	'app' => APP_PATH,
	'app_build' => APP_BUILD_PATH,
	'doc_root' => DOC_ROOT,
	'web_static' => WEB_STATIC_PATH,
	'cdn' => false
);

$settings = array(
	'timezone' => 'America/Los_Angeles',
	'error_level' => $error_level,
	'app_timestamp' => microtime(true),
	'debug_mode' => $debug,
	'site_colors' => array(
		'primary' => '#6E9D32',
		'primary-bright' => '#84BA3B',
		'secondary' => '#2D5986',
	),
);

System::init(compact('path', 'env', 'settings'));