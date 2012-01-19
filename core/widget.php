<?php

namespace jetstream\core;

class Widget {

	public $request;
	public $view;
	private $_class = null;
	private $_method = null;
	public $auto_queue = true;
	public $auto_generate_css = true;
	public $auto_container = true;

	public function __construct($params) {
		$this->_class = $params['class'];
		$this->_method = $params['method'];
		$this->request = System::request();
		$this->view = new template\View();
	}

	public function init($vars = array()) {
		$this->view->setTemplate('widget' . DS . $this->_class . DS . $this->_method);
		return true;
	}

	public function render() {
		return $this->view->render();
	}

}