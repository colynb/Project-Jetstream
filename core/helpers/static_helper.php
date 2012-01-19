<?php

use jetstream\core\System;
use jetstream\core\http\Router;
use jetstream\core\debug\Debug;

class Static_Helper {

	public function path($name) {
		return System::__static($name);
	}

}