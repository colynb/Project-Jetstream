<?php


use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;

class Navigation_Widget extends Widget {

	public $auto_queue = true;

	public function __call($name, $vars=array()) {
		if (isset($this->request->named['vmarket'])) {
			$vars['vmarket'] = $this->request->named['vmarket'];
		}
		$this->view->set($vars);
	}
}