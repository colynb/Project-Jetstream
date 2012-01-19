<?php

namespace jetstream\core\data;

use jetstream\core\debug\Debug;
use jetstream\core\System;

class Connection {
	public static $_configs = array();
	private static $_loaded = array();
	private static $_adapter_namespace = 'jetstream\core\data\adapters\\';

	public static function add(array $config = array()) {
		return self::$_configs = $config + self::$_configs;
	}

	public static function get($name = null) {

		if ( !isset(self::$_configs[$name]) ) {
			return null;
		}

		if ( !isset(self::$_loaded[$name]) ) {
			$path = self::$_configs[$name]['type'] . DS . self::$_configs[$name]['adapter'] . '.php';
			$info = System::findFile($path);
			require_once $info['path'];
			self::$_loaded[$name] = new self::$_configs[$name]['adapter'](self::$_configs[$name]);
		}

		return self::$_loaded[$name];
	}
}
