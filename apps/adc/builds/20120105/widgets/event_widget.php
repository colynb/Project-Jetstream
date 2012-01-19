<?php

use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;

class Event_Widget extends Widget {

	public function __call($name, $vars=array()) {
		$this->view->set($vars[0]);
	}

}