<?php
namespace jetstream\core\data\adapters;

use \Exception;

class MySQL {

	private $_connection;
	private $_dsn_config;

	public function __construct($dsn_config) {

		$this->_dsn_config = $dsn_config;
	}

	private function _connection() {
		if ( !isset($this->_connection) ) {

			try {
				$this->_connection = mysql_connect($this->_dsn_config['host'], $this->_dsn_config['user'], $this->_dsn_config['password']);
				mysql_select_db($this->_dsn_config['database'], $this->_connection);
			} catch ( Exception $e ) {
				throw new Exception($e->getMessage());
			}
		}
		return $this->_connection;
	}

	public function prepare( $sql, $params = array()){
		$con = $this->_connection();
		foreach ($params as $key => $value)
		{
			// new types can be added as necessary
			$sql = preg_replace("/::\(int\)".$key."\b/",  "'" . (int) mysql_real_escape_string($value, $con) . "'", $sql);
			$sql = preg_replace("/::\(float\)".$key."\b/",  "'" . (float) mysql_real_escape_string($value, $con) . "'", $sql);
			$sql = preg_replace("/::\(string\)".$key."\b/", "'" . (string) mysql_real_escape_string($value, $con) . "'", $sql);
			$sql = preg_replace("/::\(datetime\)".$key."\b/", "'" . (string) mysql_real_escape_string(date('Y-m-d H:i:s', strtotime($value)), $con) . "'", $sql);
		}
		return $sql;
	}

	public function execute($sql, $params = array()) {
		$con = $this->_connection();
		$sql = $this->prepare($sql, $params);
		$results = mysql_query( $sql, $con );
		$error = mysql_error($con);
		if($error){
			throw new Exception($error);
		}
		return $results;
	}

	public function process($sql, $params = array()) {
		$results = $this->execute($sql, $params);
		//echo mysql_affected_rows(); exit;
		return mysql_affected_rows();
	}

	public function getAll($sql, $params = array()) {
		$results = $this->execute($sql, $params);
		$return_array = array();
		if($results){
			while ( $row = mysql_fetch_assoc($results) ){
				$return_array[] = $row;
			}
		}

		if(count($return_array) > 0){
			return $return_array;
		}else{
			return false;
		}
	}

	public function getRow($sql, $params = array()) {
		$results = $this->getAll($sql, $params);
		if($results){
			return $results[0];
		}
		return false;
	}

	public function lastInsertID() {
		return mysql_insert_id($this->_connection());
	}
}
