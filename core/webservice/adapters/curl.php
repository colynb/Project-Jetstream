<?php


use jetstream\core\debug\Debug;

class Curl {
	private $host = null;
	private $port = 80;
	private $params = null;
	private $session = null;
	private $rawResponse = null;
	private $xmlResponse = null;
	private $error = null;

	public function __construct() {

	}

	public function setHost($host) {
		!empty($host) ? $this->host = $host : null;
	}

	public function setPort($port) {
		!empty($port) ? $this->port = $port : null;
	}

	public function setParams($params) {
		!empty($params) ? $this->params = $params : null;
	}

	public function call() {
		if ( empty($this->host) ) {
			throw new Exception(get_class($this) . ': Host not set.');
		}

		$params = array();
		if ( is_array($this->params) ) {
			foreach ( $this->params as $key => $value ) {
				$params[] = $key . '=' . urlencode($value);
			}
		}
		$host = $this->host . "?" . implode('&', $params);
		Debug::console('Curl host', $host);
		$this->session = curl_init();
		curl_setopt($this->session, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->session, CURLOPT_URL, $host);
		curl_setopt($this->session, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->session, CURLOPT_SSL_VERIFYHOST, 0);
		$this->rawResponse = curl_exec($this->session) ? : null;
		$this->xmlResponse = new SimpleXmlElement($this->rawResponse, LIBXML_NOCDATA);
		$this->error = curl_error($this->session) ? : null;
		curl_close($this->session);
	}

	public function getXmlResponse() {
		if ( empty($this->xmlResponse) ) {
			throw new Exception(get_class($this) . ': xmlResponse not set.');
		}

		return $this->xmlResponse;
	}
}