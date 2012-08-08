<?php

namespace jetstream\core;

use jetstream\core\debug\Debug;

require_once CORE_PATH . DS . 'loader.php';

$classLoader = new \SplClassLoader('jetstream', FRAMEWORK_PARENT);
$classLoader->register();


include APP_BUILD_PATH . DS . 'config/init/routes.php';
include APP_BUILD_PATH . DS . 'config/init/connections.php';