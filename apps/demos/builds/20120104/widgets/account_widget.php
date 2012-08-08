<?php


use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;

class Account_Widget extends Widget {
	public $auto_queue = true;

	public function __call($name, $vars=array()) {
		$this->view->set($vars);
		$this->view->setTemplate('widget' . DS . 'account' . DS . $name);
		return $this->view->render();
	}
}