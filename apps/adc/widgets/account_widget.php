<?php

class Account_Widget extends jetstream\core\Widget {

	public function __call($name, $vars=array()) {
		$this->view->set($vars);
	}

}