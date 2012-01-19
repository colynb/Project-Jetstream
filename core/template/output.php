<?php

namespace jetstream\core\template;

use \jetstream\core\debug\Debug;
use jetstream\core\System;



class Output {
	private $_output;

	public function init($output) {

		$this->_patterns = array(
			'/{COMPILE:([^:]{0,}):?([^}]{0,})}/e' => "jetstream\core\System::$1('$2')"
		);

		$this->_output = $output;
		return $this;
	}

	public function compile() {
		$this->_output = preg_replace(array_keys($this->_patterns), array_values($this->_patterns), $this->_output);
		return $this;
	}

	public function __toString() {
		return $this->_output;
	}
}

