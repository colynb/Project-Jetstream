<?php

use jetstream\core\debug\Debug;

class Account_Api extends \jetstream\core\Controller {

	public $_params = array(
		'use_view' => false
	);

	public function action_login_post() {
		$content = json_encode($this->request->post);
		return $this->response(compact('content'));
	}


}