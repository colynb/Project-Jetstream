<?php

use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;
use jetstream\core\debug\Profiler;

class Profiler_Widget extends Widget {
	public $auto_queue = true;

	public function init($params = array()) {
		parent::init($params);
		if (System::$env == 'production') return false;
		return true;
	}

	public function report($vars=array()) {
		Profiler::track(System::$profiler_id);
		Profiler::denit();
		$this->view->set($vars);
	}
}