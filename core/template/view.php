<?php

namespace jetstream\core\template;

use jetstream\core\System;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\helper;

class View {

	private $_buffers = array();
	private $_template;
	private $_layout = false;
	public $_vars = array();
	private $_rendered = '';
	public $id = null;

	public function __construct() {
		$this->id = uniqid();
		$this->request = System::request();
	}

	public function render() {
		$this->buffer('template', 'views/' . strtolower($this->_template) . '.tpl.php');
		if ( $this->_layout ) {
			$this->buffer('layout', 'views/layouts/' . strtolower($this->_layout) . '.tpl.php');
			unset($this->_buffers['template']);
		}
		return $this->_rendered = join('', $this->_buffers);
	}

	public function buffer($buffer_name, $buffer_file = false) {



		if ( $buffer_file === false && isset($this->_buffers[$buffer_name]) ) {
			return $this->_buffers[$buffer_name];
		}

		$id = $this->id;
		$vars = $this->_vars;

		if ( !empty($buffer_file) && $found = System::findFile($buffer_file) ) {
			ob_start();
			extract($this->_vars);
			try {
				require_once $found['path'];
			} catch ( Exception $e ) {

			}
			$this->_buffers[$buffer_name] = ob_get_clean();
		} elseif ( !empty($buffer_file) ) {
			debug::console('Missing Templates', $buffer_file);
		}
	}

	public function setTemplate($template) {
		$this->_template = $template;
	}

	public function setLayout($template) {
		$this->_layout = $template;
	}

	public function set(Array $vars = array()) {
		$this->_vars = $vars;
	}

	public function widget($widget_name, $vars = array()) {

		$parsed = $this->_parseString($widget_name);

		$file = 'widgets' . DS . strtolower($parsed['class']) . '_widget.php';

		if ( $found = System::findFile($file) ) {
			require_once $found['path'];
		}


		$class = $parsed['class'] . '_Widget';
		$obj = new $class($parsed);

		// You can use it to turn off different widgets by returning false
		$show = $obj->init();

		if ( !$show ) return '';

		/**
		 * Auto generate css and js files
		 * This is for development only to help increase production
		 */
		if ( $obj->auto_generate_css && $obj->auto_queue ) {
			$file = strtolower('static' . DS . 'css' . DS . 'widget' . DS . $parsed['class'] . DS . $parsed['method']) . '.css';
			$info = System::findFile($file);

			if (!$info) {
				debug::console('Widget CSS - Creating', $file . '&nbsp;&nbsp;<small><a href="#">Create</a></small>');
			} else {
				debug::console('Widget CSS', $info['path']);
			}


		}

		/**
		 * Auto queue of CSS and JS
		 */
		if ( $obj->auto_queue ) {
			$file = strtolower('widget' . DS . $parsed['class'] . DS . $parsed['method']);
			$this->queue('css', array('src' => '/css/' . $file . '.css'));
			$this->queue('js', array('src' => '/js/' . $file . '.js'));
		}

		$content = $obj->{$parsed['method']}($vars);
		if ( empty($content) ) {
			$content = $obj->render();
		}

		if ( $obj->auto_container ) {
			$content = '<div class="widget-container ' . strtolower($parsed['class'] . '-' . $parsed['method']) . '">' . $content . '</div>';
		}

		return $content;
	}

	public function __get($name) {

		$file = 'helpers' . DS . strtolower($name) . '_helper.php';
		if ( $found = System::findFile($file) ) {
			require_once $found['path'];
			$class = $name . '_Helper';
			return new $class($this);
		}
	}

	public function queue($type, $info) {
		System::queue($type, $info);
	}

	public function getQueued($type) {
		System::getQueued($type);
	}

	private function _parseString($path) {
		list($class, $method) = explode('::', $path, 2);
		return compact('class', 'method');
	}

	public function template($template, $vars = array(), $cache_time = 0) {

		if ( $info = System::findFile('views' . DS . $template . '.tpl.php') ) {
			extract($vars);
			ob_start();
			include $info['path'];
			return ob_get_clean();
		}
	}

}