<?php

use jetstream\core\System;
use jetstream\core\http\Router;
use jetstream\core\debug\Debug;

class Route_Helper {

	public function url($name, $params=array()) {
		return Router::url($name, $params);
	}

}