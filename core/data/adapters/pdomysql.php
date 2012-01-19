<?php

namespace jetstream\core\data\adapters;

use \PDO;

class PDOMySQL {
	private $_connection;
	private $_dsn_config;

	public function __construct($dsn) {
		$dsn_config = array(
			'dsn' => 'mysql:dbname=' . $dsn['database'] . ";host=" . $dsn['host'],
			'user' => $dsn['user'],
			'password' => $dsn['password']);

		$this->_dsn_config = $dsn_config;
	}

	private function _connection() {
		if ( !isset($this->_connection) ) {
			try {
				$this->_connection = new PDO($this->_dsn_config['dsn'], $this->_dsn_config['user'], $this->_dsn_config['password']);
			} catch ( PDOException $e ) {
				throw new Exception($e->getMessage());
			}
		}
		return $this->_connection;
	}

	public function execute($sql, $params = array()) {
		$con = $this->_connection();
		$stmt = $con->prepare($sql);
		$stmt->execute($params);
	}

	public function getAll($sql, $params = array()) {
		$con = $this->_connection();
		$stmt = $con->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getRow($sql, $params = array()) {
		$con = $this->_connection();
		$stmt = $con->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function lastInsertID() {
		$con = $this->_connection();
		foreach ( $con->query('SELECT LAST_INSERT_ID()') as $row ) {
			$return = $row[0];
		}
		return $return;
	}
}

