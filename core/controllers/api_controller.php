<?php

use jetstream\core\System;
use jetstream\core\debug\Debug;
use jetstream\core\http\Response;

class Api_Controller extends \jetstream\core\Controller {
	public $request;
	public $view;
	public $layout = false;
	protected $response;

	public function action_init() {
		$version = $this->request->named['version'];
		$class = $this->request->named['class'];
		$method = $this->request->named['method'];
		$args = $this->request->args;
		$request_method = $this->request->server['REQUEST_METHOD'];
		return $this->load(compact('version', 'class', 'method', 'request_method', 'args'));
	}

	public function load($params) {

		$path = array(
			'api',
			$params['version'],
			strtolower($params['class']) . '_api.php'
		);

		$file = join(DS, $path);
		$class = $params['class'] . '_Api';
		$method = strtolower('action_' . $params['method'] . '_' . $params['request_method']);

		if ( $found = System::findFile($file) ) {

			require_once $found['path'];

			$obj = new $class();
			$obj->init($params);

			if ( method_exists($obj, $method) ) {
				if ( ($response = $obj->{$method}()) instanceof Response ) {
					return $response;
				} else {
					$response = $obj->response();
				}
			} else {

				$response = new Response('error');
				$response->setStatusCode(500);
			}
		} else {
			$response = new Response('error');
			$response->setStatusCode(500);
		}
		return $response;
	}
}