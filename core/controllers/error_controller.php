<?php

namespace jetstream\core\controllers;
use jetstream\core\System;

class Error_Controller extends \jetstream\core\Controller {

	public function action_error404() {
		$this->response->setStatusCode(404);
	}

	public function action_showErrors($errors) {
		$this->_params['layout'] = false;
		$this->view->set(compact('errors'));
	}

}