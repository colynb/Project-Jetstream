<?php

namespace jetstream\core\http;

use jetstream\core\System;
use jetstream\core\debug\Debug;

class Router {

	public static $_routes = array();
	private static $_pattern = '';
	private static $_match_url = '';
	private static $_filter;

	public static function set($name = 'default', $path, $dest = null, $defaults = array()) {
		if ( is_callable($dest) ) {
			self::$_routes[$name]['closure'] = $dest;
		} elseif ( is_scalar($dest) ) {
			self::$_routes[$name] = self::_parseDest($dest);
		} elseif ( is_array($dest) ) {
			self::$_routes[$name] = $dest;
		} else {
			self::$_routes[$name] = array();
		}

		self::$_pattern = "@^{$path}\$@";
		$match = '@([/.])?\{:([^:}]+):?((?:[^{]+(?:\{[0-9,]+\})?)*?)\}@S';
		preg_match_all($match, self::$_pattern, $m);
		self::$_routes[$name]['keys'] = array();
		foreach ( $m[2] as $i => $param ) {
			self::$_routes[$name]['keys'][$param] = $param;
			self::$_pattern = self::_regex($m[3][$i], $param, $m[0][$i], $m[1][$i]);
		}


		self::$_routes[$name]['defaults'] = $defaults + array('args' => null);
		self::$_routes[$name]['path'] = $path;
		self::$_routes[$name]['pattern'] = self::$_pattern;
	}

	public static function process(Request $request) {


		$match = false;

		self::$_match_url = $request->canonical;

		// 1. Loop through each route
		$route_vars = array();
		foreach ( self::$_routes as $name => $route ) {
			$matches = array();
			//$route_vars = array(); // removed all the extraneous preg_match results
			// Check route pattern against URL

			if ( in_array($name, array('home', 'static')) ) {
				preg_match($route['pattern'], self::$_match_url, $matches);
			} else {
				preg_match($route['pattern'], self::$_match_url . '/', $matches);
			}



			// If there are matches...
			if ( count($matches) ) {

				$match = true;

				// parse matches for key/values
				$route_vars = array_intersect_key($matches, $route['keys']) + $route['defaults'];
				$args = (isset($route_vars['args'])) ? preg_split("/\//", $route_vars['args'], -1, PREG_SPLIT_NO_EMPTY) : array();

				//unset($clean['args']);
				if ( !empty($route['continue']) ) {
					self::$_match_url = '/' . $route_vars['args'];
					$request->setNamedParams($route_vars + $route['defaults']);
					continue;
				} elseif ( !empty($route['closure']) ) {
					return $route['closure']($route);
					break;
				} elseif ( isset($route['controller']) && isset($route['action']) ) {
					debug::console('Found Route', $name);
					$class = $route['controller'];
					$method = $route['action'];
					if ( isset($route_vars['args']) ) {
						$request->canonical = rtrim(str_replace(rtrim($route_vars['args'], '/'), '', $request->canonical), '/');
					}
					debug::console('Canonical URL', $request->canonical);

					break;
				} elseif ( isset($route_vars['controller']) && isset($route_vars['action']) ) {

					debug::console('Found Route', $name);
					$class = $matches['controller'];
					$method = $matches['action'];
					if ( isset($route_vars['args']) ) {
						$request->canonical = rtrim(str_replace(rtrim($route_vars['args'], '/'), '', $request->canonical), '/');
					}
					debug::console('Canonical URL', $request->canonical);
					break;
				}
			}
		}

		if ( !$match ) return false;

		$request->setRouteInfo($route);
		$request->setArgs($args);
		$request->setNamedParams($route_vars + $route['defaults']);

		return compact('class', 'method');
	}

	public static function _parseDest($path) {
		list($controller, $action) = explode('::', $path, 2);
		return compact('controller', 'action');
	}

	private static function _regex($regex, $param, $token, $prefix) {
		if ( $regex ) {

		} elseif ( $param == 'args' ) {
			$regex = '.*';
		} else {
			$regex = '[^\/]+';
		}
		$req = '';

		if ( $prefix === '/' ) {
			$pattern = "(?:/(?P<{$param}>{$regex}){$req}){$req}";
		} elseif ( $prefix === '.' ) {
			$pattern = "\\.(?P<{$param}>{$regex}){$req}";
		} else {
			$pattern = "(?P<{$param}>{$regex}){$req}";
		}
		return str_replace($token, $pattern, self::$_pattern);
	}

	public static function url($name, $params=array()) {

		//debug::dump(self::$_routes);

		$route = self::$_routes[$name];

		$url = array(
			'scheme' => System::request()->url['scheme'] . '://',
			'host' => System::request()->url['host']
		);

		if ( isset($params['scheme']) ) {
			$url['scheme'] = $params['scheme'] . '://';
		}

		if ( isset($params['host']) ) {
			$url['host'] = $params['host'];
		}

		$link = self::$_routes[$name]['path'];
		if ( isset($route['keys']) ) {

			$args = $params + $route['defaults'] + $route['keys'];

			foreach ( $args as $key => $value ) {
				if ( $key == 'args' && is_array($value) ) {
					$value = join('/', $value);
				}
				$link = str_replace('{:' . $key . '}', $value, $link);
			}
		}
		$url[] = rtrim($link, '/');
		;
		return join('', $url);
	}

	public static function setFilter(\Closure $filter) {
		self::$_filter = $filter;
	}

}