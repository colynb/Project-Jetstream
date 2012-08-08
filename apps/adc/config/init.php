<?php

namespace jetstream\core;

use jetstream\core\debug\Debug;
use jetstream\core\Application;

require_once CORE_PATH . DS . 'loader.php';

$classLoader1 = new \SplClassLoader('jetstream', FRAMEWORK_PARENT);
$classLoader1->register();


include APP_PATH . DS . 'config/init/system.php';


if ( System::$env !== 'production' ) {
	include APP_PATH . DS . 'config/init/profiler.php';
}
include APP_PATH . DS . 'config/init/connections.php';
include APP_PATH . DS . 'config/init/cdn.php';
//include APP_BUILD_PATH . DS . 'config/init/auth.php';
include APP_PATH . DS . 'config/init/routes.php';
include APP_PATH . DS . 'config/init/queue.php';