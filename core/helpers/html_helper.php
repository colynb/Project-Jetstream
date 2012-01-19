<?php

use jetstream\core\http\Router;
use jetstream\core\debug\Debug;
class Html_Helper {

	public function link($params) {
		$link = false;
		if ( isset($params['route']) && isset(Router::$_routes[$params['route']]) ) {

			$route = Router::$_routes[$params['route']];
			$link = Router::$_routes[$params['route']]['path'];
			if ( isset($route['keys']) ) {
				$args = $params['args'] + $route['defaults'] + $route['keys'] ;
				foreach ( $args as $key => $value ) {
					$link = str_replace('{:' . $key . '}', $value, $link);
				}
			}
		} elseif ( isset( $params['link'] ) ) {
			$link = $params['link'];
		}

		if ($link) {
			$link = rtrim($link,'/');
			return '<a href="' . $link . '">' . $params['label'] . '</a>';
		}



	}

	public function csslink($params) {
		$defaults = array(
			'media' => 'screen, print',
			'rel' => 'stylesheet',
			'type' => 'text/css'
		);

		$params = $params + $defaults;

		foreach ( $params as $name => $value ) {
			$attributes[] = $name . '="' . $value . '"';
		}
		return '<link ' . join(' ', $attributes) . ' />';
	}

	public function script($params) {
		$defaults = array(
			'type' => 'text/javascript'
		);

		$params = $params + $defaults;

		foreach ( $params as $name => $value ) {
			$attributes[] = $name . '="' . $value . '"';
		}
		return '<script ' . join(' ', $attributes) . '></script>';
	}
}