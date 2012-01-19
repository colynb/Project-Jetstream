<?php

namespace jetstream\core;

use jetstream\core\debug\Debug;

class Api {
	public $request;
	private $_config = array(
	);
	protected $response;

	public function __construct($params, $vars = array()) {
		$this->request = System::request();
		$this->response = new http\Response();
	}

	public function response() {
		return $this->response;
	}
}