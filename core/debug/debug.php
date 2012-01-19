<?php

namespace jetstream\core\debug;

class Debug {

	public static $console_log = array();

	static public function dump() {
		if ( func_num_args() === 0 ) return;

		$vars = func_get_args();

		foreach ( $vars as $val ) {
			echo '<pre>' . print_r($val, 1) . '</pre>';
		}
	}

	static public function var_dump() {
		if ( func_num_args() === 0 ) return;

		$vars = func_get_args();

		echo '<pre>';
		var_dump($vars);
		echo '</pre>';
	}

	static public function source($file, $line_number, $padding = 5) {

		if ( !$file or !is_readable($file) ) {
			return FALSE;
		}

		// Open the file and set the line position
		$file = fopen($file, 'r');
		$line = 0;

		// Set the reading range
		$range = array(
			'start' => $line_number - $padding,
			'end' => $line_number + $padding
		);

		// Set the zero-padding amount for line numbers
		$format = '% ' . strlen($range['end']) . 'd';

		$source = '';
		while ( ( $row = fgets($file) ) !== FALSE ) {
			// Increment the line number
			if ( ++$line > $range['end'] ) break;

			if ( $line >= $range['start'] ) {
				$row = htmlspecialchars($row, ENT_NOQUOTES);

				$row = '<span class="number">' . sprintf($format, $line) . '</span> ' . $row;

				if ( $line === $line_number ) {
					// Apply highlighting to this row
					$row = '<span class="line highlight">' . $row . '</span>';
				} else {
					$row = '<span class="line">' . $row . '</span>';
				}

				$source .= $row;
			}
		}

		fclose($file);

		echo '<pre class="source"><code>' . $source . '</code></pre>';
	}

	static public function console($name, $mixed) {
		$trace = debug_backtrace();

		if ( !is_scalar($mixed) ) {
			$mixed = '<pre>' . print_r($mixed, 1) . '</pre>';
		}

		$key = $name . ' <small class="right">Found in ' . str_replace(FRAMEWORK_PATH, '', $trace[0]['file']) . ' on line ' . $trace[0]['line'] . '</small>';

		self::$console_log[$key][] = array(
			'dump' => $mixed,
			'trace' => $trace,
			'line' => __LINE__,
			'file' => __FILE__,
		);
	}

}