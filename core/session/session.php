<?php


class Session extends ArrayObject {
	private $_config = array(
		'namespace' => 'afw'
	);

	public function init($config=array()) {
		$this->_config = $config + $this->_config;
	}

	public function start() {
		session_start();

		if (isset($_SESSION[$this->_config['namespace']]) && is_array($_SESSION[$this->_config['namespace']])) {
			foreach ( $_SESSION[$this->_config['namespace']] as $key => $val ) {
				//$this[$key] = $val;
			}
		} else {
			$_SESSION[$this->_config['namespace']] = array();
		}
		return $this;
	}

	public function write($vars = false) {
		if (!is_array($vars)) return false;
		$this->start();
		foreach ( $vars as $key => $val ) {
			$_SESSION[$this->_config['namespace']][$key] = $val;
		}
	}

	public function addViewedAsset(array $vars) {
		foreach ( $vars as $category => $val ) {

			$array_keys = array_keys($_SESSION[$this->_config['namespace']][$category]);
			if ( !is_array($_SESSION[$this->_config['namespace']][$category]) ) { //make sure category is an array
				$_SESSION[$this->_config['namespace']][$category] = array();
			}

			foreach( $val as $asset_info ) {
				if( array_search($asset_info['ASSET_ID'], $array_keys) !== false) { //check to see if asset was viewed previously
					unset($_SESSION[$this->_config['namespace']][$category][$asset_info['ASSET_ID']]);
				}

				if ( !is_array($_SESSION[$this->_config['namespace']][$category][$asset_info['ASSET_ID']]) ) { //make sure asset id is an array
					$_SESSION[$this->_config['namespace']][$category][$asset_info['ASSET_ID']] = array();
				}
				//add asset on to end of category array
				$_SESSION[$this->_config['namespace']][$category][$asset_info['ASSET_ID']] = array_merge($asset_info, $_SESSION[$this->_config['namespace']][$category][$asset_info['ASSET_ID']]);
			}
		}

		$limit = 11;
		if( count($_SESSION[$this->_config['namespace']][$category]) == $limit ) {
			unset($_SESSION[$this->_config['namespace']][$category][$array_keys[0]]);
		}
		//Debug::dump($_SESSION[$this->_config['namespace']][$category]);
	}

	public function getViewedAssets() {
		return $_SESSION[$this->_config['namespace']]['viewed_asset'];
	}

	public function showSession() {
		Debug::dump($_SESSION);
	}
}