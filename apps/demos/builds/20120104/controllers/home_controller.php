<?php

class Home_Controller extends \jetstream\core\Controller {

	public function action_view() {
		$this->view->setLayout('default_layout');
	}

	public function action_welcome() {
		$this->view->set(array(
			'message' => 'Hello World!'
		));
	}
}