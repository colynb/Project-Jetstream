<?php

namespace libraries\search;

use jetstream\core\data\Connection;
use jetstream\core\debug\Debug;

class Search {
	private $_loaded = false;
	private $_adapter = null;
	private $_params = array();
	private $_config = array(
		'connection_name' => 'default_search'
	);

	public function config($config) {
		$this->_config = $config + $this->_config;
	}

	private function _init() {
		if ( $this->_loaded ) {
			return true;
		}

		$this->_loaded = true;

		$this->_adapter = Connection::get($this->_config['connection_name']);		
	}

	public function setParam($name, $value) {
		$this->_init();
		$this->_adapter->setParam($name, $value);
	}

	public function setParams($params) {
		$this->_init();
		$this->_adapter->setParams($params);
	}

	public function getParams() {
		$this->_init();
		return $this->_adapter->getParams();
	}

	public function getResults($type = false) {
		$this->_init();
		return $this->_adapter->getResults($type);
	}

	public function getRefinements() {
		$this->_init();
		return $this->_adapter->getRefinements();
	}

	public function getSortOptions() {
		$this->_init();
		return $this->_adapter->getSortOptions();
	}

	public function getBreadcrumb() {
		$this->_init();
		return $this->_adapter->getBreadcrumb();
	}

	public function getMeta() {
		$this->_init();
		return $this->_adapter->getMeta();
	}

	public function getPagination() {
		$this->_init();
		return $this->_adapter->getPagination();
	}

	public function classType() {
		$this->_init();
		return $this->_adapter->classType();
	}
}

?>
