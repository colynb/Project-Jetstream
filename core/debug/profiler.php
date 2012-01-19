<?php

namespace jetstream\core\debug;

class Profiler {
	public static $_default_category = 'profiler';
	public static $_tracker = array();
	public static $_start_time;
	public static $_end_time;
	public static $_params = array();
	public static $_task_id = 0;

	public static function init() {

		self::$_start_time = time();
		self::$_params = array(
			'task_id' => self::newTaskId(),
			'title' => 'Profiler Start',
			'time' => self::$_start_time,
			'comment' => ''
		);

		self::track(self::$_params);


	}

	public static function newTaskId() {
		return self::$_task_id++;
	}

	public static function track($parameters = array()) {

		$time = microtime(true);

		if ( !is_array($parameters) ) {
			$parameters = array('title' => $parameters);
		}

		$time = isset($parameters['time']) ? $parameters['time'] : $time;
		$task_id = isset($parameters['task_id']) ? (int) $parameters['task_id'] : self::newTaskId();
		$title = isset($parameters['title']) ? (string) $parameters['title'] : 'Task ID: ' . $task_id;
		$comment = isset($parameters['comment']) ? (string) $parameters['comment'] : '';
		$category = isset($parameters['category']) ? (string) $parameters['category'] : self::$_default_category;

		self::$_tracker[$category][] = array('task_id' => $task_id, 'time' => $time, 'title' => $title, 'comment' => $comment);
		return $task_id;
	}

	public static function denit() {
		self::$_end_time = self::$_params['time'] = microtime(true);
		self::track(self::$_params);
	}

	public static function dump() {
		Debug::dump(self::$_tracker);
	}
}

?>