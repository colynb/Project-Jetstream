<?php

use jetstream\core\debug\Debug;

class User_Api extends \jetstream\core\Controller {

	public $_params = array(
		'use_view' => false
	);
	
	public function action_list_get() {
		$content = json_encode($this->request->get);
		return $this->response(compact('content'));
	}

	public function action_list_post() {
		$content = json_encode($this->request->post);
		return $this->response(compact('content'));
	}

	public function action_list_put() {
		$content = json_encode(array('content'=>$this->request->put));
		return $this->response(compact('content'));
	}


}