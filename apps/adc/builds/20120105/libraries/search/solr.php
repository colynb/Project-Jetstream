<?php

class SolrSearch {
	private $_config;
	private $_executed;
	private $_results;
	private $_meta;
	private $_refinements;
	private $_pagination;
	private $_params;
	private $_class_type = 'solr';

	public function __construct($config) {

		$this->_config = $config;

		if (is_array($this->_config['params'])) {
			$this->_params = $this->_config['params'];
		}
	}

	public function execute($params) {
		if ( $this->_executed ) {
			return true;
		}

		$this->_executed = true;

		// API code to generate XML result goes here
		// Parse XML as arrays into the following sections
		// Generate Results array
		$this->_results = array(
			array(
				'id' => 1,
				'title' => 'Some house',
				'address' => '1 mauchly, Irvine CA'
			),
			array(
				'id' => 2,
				'title' => 'Some other house',
				'address' => '2 mauchly, Irvine CA'
			),
		);

		// Generate Meta data array (total, page count etc)
		$this->_meta = array();

		// Generate Refinements array (facets)
		$this->_refinements = array();

		// Generate Pagination array (facets)
		$this->_pagination = array();
	}

	public function setParam($name, $value) {
		$this->_params[$name] = $value;
	}

	public function setParams($params) {
		$this->_params = $params;
	}

	public function getParams() {
		return $this->_params;
	}

	public function getResults($type = false) {
		$this->execute($this->_params);

		if ($type == 'json') {
			return json_encode($this->_results);
		}
		return $this->_results;
	}

	public function getMeta() {
		$this->execute($this->_params);
		return $this->_meta;
	}

	public function getRefinements() {
		$this->execute($this->_params);
		return $this->_refinements;
	}

	public function getPagination() {
		$this->execute($this->_params);
		return $this->_pagination;
	}

	public function classType() {
		return $this->_class_type;
	}
}

?>
