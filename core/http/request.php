<?php

namespace jetstream\core\http;

use jetstream\core\debug\debug;

class Request {
	public $post = null;
	public $get = null;
	public $file = null;
	public $server = null;
	public $put = null;
	public $node = null;
	public $canonical = null;
	public $named = array();
	public $route = null;
	public $args = null;

	public function __construct(array $params = array()) {

		$params = array(
			'get' => isset($params['get']) ? $params['get'] : $_GET,
			'post' => isset($params['post']) ? $params['post'] : $_POST,
			'put' => isset($params['put']) ? $params['put'] : file_get_contents('php://input'),
			'cookie' => isset($params['cookie']) ? $params['cookie'] : $_COOKIE,
			'file' => isset($params['file']) ? $params['file'] : $_FILES,
			'server' => isset($params['server']) ? $params['server'] : $_SERVER,
		);

		$this->post = filter_var_array($params['post'], FILTER_SANITIZE_STRING);
		$this->get = filter_var_array($params['get'], FILTER_SANITIZE_STRING);
		$this->file = $params['file'];
		$this->server = $params['server'];
		$this->put = $params['put'];
		$url = (!empty($this->server['REDIRECT_URL'])) ? $this->server['REDIRECT_URL'] : '/';
		$this->node = preg_split("/\//", $url, -1, PREG_SPLIT_NO_EMPTY);
		$this->canonical = str_replace('//', '/', '/' . implode('/', $this->node)); // this can be overridden in the router.cfg
		$url = array(
			($this->isSecure()) ? 'https://' : 'http://',
			$this->server['HTTP_HOST'],
			$this->canonical,
			(count($this->get)) ? '?' . http_build_query($this->get) : ''
		);
		$full = join('',$url);

		$this->url = parse_url($full) + compact('full');
	}

	public function setNamedParams($named) {
		$this->named += $named;
	}

	public function setRouteInfo($route) {
		$this->route = $route;
	}

	public function setArgs($args) {
		$this->args = $args;
	}

	public function isSecure() {
		return (isset($this->server['HTTPS'])) ? true : false;
	}

	public function setDevice($default = 'desktop') {
		$this->device = $device;
		$this->device_default = $device;
		foreach ( $this->_mobile_devices as $device ) {
			if ( stristr($this->server['HTTP_USER_AGENT'], $device) && in_array('mobile', System::Build()->info['devices']) ) {
				$this->device = 'mobile';
				break;
			}
		}
	}
}