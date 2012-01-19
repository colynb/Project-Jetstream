<?php

namespace jetstream\core;

use jetstream\core\debug\Debug;

class Controller {
	public $request;
	public $view;
	protected $_params = array(
		'use_view' => true,
		'layout' => 'default_layout',
		'content' => null
	);
	protected $response;

	public function init($params) {

		$this->_params = $params + $this->_params;
		$this->_params['template'] = $params['class'] . DS . $params['method'];
		$this->request = System::request();
		$this->response = new http\Response();

		if ( $this->_params['use_view'] ) {
			$this->view = new template\View();
		}

		if (isset($this->request->named['vmarket']) && $this->request->named['vmarket'] == 'home') {
			$this->_params['vmarket'] = 'gateway_layout';
		}
	}

	public function set($vars = array()) {
		$this->view->set($vars);
	}

	public function response(array $params = array()) {

		$this->_params = $params + $this->_params;

		if ( $this->_params['use_view'] ) {
			if ( $this->_params['layout'] ) {
				$this->view->setLayout($this->_params['layout']);
			}
			$this->view->setTemplate($this->_params['template']);
			$this->_params['content'] = $this->view->render();
		}
		$this->response->setContent($this->_params['content']);
		return $this->response;
	}
}