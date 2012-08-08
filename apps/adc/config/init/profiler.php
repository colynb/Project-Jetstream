<?php

use jetstream\core\debug\Profiler;
use jetstream\core\System;

Profiler::init();
Profiler::track(System::$profiler_id = array('title' => 'Profiler Total', 'task_id' => Profiler::newTaskId()));

