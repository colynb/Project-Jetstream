<?php

use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;

class Search_Widget extends Widget {

	public function __call($widget_name, $vars=array()) {
		$this->view->set($vars[0]);
	}

}