<?php

class Home_Controller extends \jetstream\core\Controller {

	public function action_gateway() {
		$this->_params['layout'] = 'gateway_layout';
	}

	public function action_vmarket() {
		$this->view->set($this->request->named);
	}
}