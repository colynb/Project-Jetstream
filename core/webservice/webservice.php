<?php

namespace jetstream\core\webservice;

class WebService {
	private $protocol = null;
	private $protocolAccessList = array('curl');
	private $callObject = null;

	public function __construct() {

	}

	public function setConfig($config) {
		isset($config['protocol']) ? $this->setProtocol($config['protocol']) : null;
		isset($config['host']) ? $this->setHost($config['host']) : null;
		isset($config['port']) ? $this->setPort($config['port']) : null;
	}

	public function setProtocol($protocol) {
		if ( !empty($protocol) && in_array($protocol, $this->protocolAccessList) ) {
			require_once('adapters/' . ucfirst(strtolower($protocol)) . '.php');
			$callObject = ucfirst(strtolower($protocol));
			$this->callObject = new $callObject;
			$this->protocol = $protocol;
		}
	}

	public function setHost($host) {
		if ( empty($this->callObject) ) {
			throw new Exception(get_class($this) . ': Protocol not set.');
		}

		$this->callObject->setHost($host);
	}

	public function setPort($port) {
		if ( empty($this->callObject) ) {
			throw new Exception(get_class($this) . ': Protocol not set.');
		}

		$this->callObject->setPort($port);
	}

	public function setParams($params) {
		if ( empty($this->callObject) ) {
			throw new Exception(get_class($this) . ': Protocol not set.');
		}

		$this->callObject->setParams($params);
	}

	public function call() {
		if ( empty($this->callObject) ) {
			throw new Exception(get_class($this) . ': Protocol not set.');
		}

		$this->callObject->call();
	}

	public function getXmlResponse() {
		if ( empty($this->callObject) ) {
			throw new Exception(get_class($this) . ': Protocol not set.');
		}

		return $this->callObject->getXmlResponse();
	}
}