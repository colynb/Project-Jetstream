<?php

namespace jetstream\core;

use jetstream\core\http\Response;
use jetstream\core\controllers\Error_Controller;
use jetstream\core\debug\Debug;
use jetstream\core\debug\Profiler;
use jetstream\core\data\Broker;

class System {

	private static $_libraries = array();
	private static $_queues = array(
		'css' => array(),
		'js' => array()
	);
	public static $profiler_id;
	public static $path;
	public static $env;
	public static $settings;

	public static function init($vars) {

		self::$path = $vars['path'];
		self::$env = $vars['env'];
		self::$settings = $vars['settings'];

		error_reporting(self::$settings['error_level']);
		register_shutdown_function(function() {
			$params = array(
				'errors' => error_get_last(),
			);
			System::shutdownHandler($params);
		});
	}

	public static function shutdownHandler($params) {
		if ( count($params['errors']) ) {
			require_once self::$path['core'] . DS . 'controllers/error_controller.php';
			$class = 'Error';
			$method = 'showErrors';
			$error = new Error_Controller();
			$error->init(compact('class', 'method'));
			$error->action_showErrors($params['errors']);
			echo $error->response();
		}
	}

	public static function request() {
		if ( isset(self::$_libraries['request']) ) return self::$_libraries['request'];
		return self::$_libraries['request'] = new http\Request(array());
	}

	public static function view() {
		if ( isset(self::$_libraries['view']) ) return self::$_libraries['view'];
		return self::$_libraries['view'] = new template\View(array());
	}

	public static function data() {
		if ( isset(self::$_libraries['data']) ) return self::$_libraries['data'];
		return self::$_libraries['data'] = new Broker();
	}

	public static function auth() {
		if ( isset(self::$_libraries['auth']) ) return self::$_libraries['auth'];
		return self::$_libraries['auth'] = new session\UserAuth();
	}

	public static function output() {
		if ( isset(self::$_libraries['output']) ) return self::$_libraries['output'];
		return self::$_libraries['output'] = new template\Output();
	}

	public static function run(http\Request $request) {
		$response = self::loadController(http\Router::process($request));
		if ( $response instanceof http\Response ) {
			$response->sendHeaders();
			$output = new template\Output();
			$response->content = $output->init($response->content);
			return $response->content->compile();
		}
	}

	public static function loadController($params) {

		if (!is_array($params)) {
			$params = self::_parseDest($params);
		}

		if ( false === $params ) return false;

		$file = 'controllers' . DS . strtolower($params['class']) . '_controller.php';
		$class = $params['class'] . '_Controller';
		$method = 'action_' . $params['method'];

		if ( $found = self::findFile($file) ) {
			require_once $found['path'];

			/**
			 * Error class is already loaded, but for some reason,
			 * because the class name is a variable, it wants to get
			 * passed through the auto loader in which case it can't find it.
			 * Not sure why yet. For now, just check it and set it.
			 */
			if ( $class == 'Error_Controller' ) {
				$obj = new Error_Controller();
			} else {
				$obj = new $class();
			}

			$obj->init($params);

			if ( method_exists($obj, $method) ) {
				if ( ($response = $obj->{$method}()) instanceof Response ) {
					return $response;
				} else {
					return $obj->response();
				}
			}
		}
		$response = self::loadController('Error::error404');
		$response->setStatusCode(404);
		return $response;
	}

	public static function queue($type, $info) {
		if ( !preg_match("/^http/", $info['src']) ) {
			$info['src'] = WEB_STATIC_PATH . $info['src'];
		}

		if ( !isset(self::$_queues[$type]) || !in_array($info, self::$_queues[$type]) ) {
			self::$_queues[$type][] = array("info" => $info);
		}
	}

	public static function getQueued($type) {
		if ( isset(self::$_queues[$type]) && is_array(self::$_queues[$type]) ) {
			return self::$_queues[$type];
		} else {
			return array();
		}
	}

	public static function findFile($path, $params=array()) {

		$default = array(
			'app_build_path' => APP_BUILD_PATH,
		);

		$params = $params + $default;

		$dirs = array(
			array('path' => $params['app_build_path']),
			array('path' => $params['app_build_path'] . DS . 'libraries'),
			array('path' => SYSTEM_APP_PATH)
		);

		foreach ( $dirs as $dir ) {
			if ( is_file($dir['path'] . DS . $path) ) {
				return array('root' => $dir, 'path' => $dir['path'] . DS . $path);
			}
		}
	}

	public static function _parseDest($path) {
		list($class, $method) = explode('::', $path, 2);
		return compact('class', 'method');
	}

	public static function __widget($name) {
		return self::view()->widget($name);
	}

	public static function __static($path) {
		return '/static/' . APP_BUILD_ID . '-' . APP_CACHE_ID . $path;
	}

	public static function __color($name) {

		if ( isset(self::$settings['site_colors'][$name]) ) {
			return self::$settings['site_colors'][$name];
		}
	}

}