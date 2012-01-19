<?php


use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;

class Console_Widget extends Widget {
	public $auto_queue = true;

	public function init($params = array()) {
		parent::init($params);
		if (System::$env == 'production') return false;
		return true;
	}

	public function __call($name, $vars=array()) {
		$this->view->set($vars);
	}
}