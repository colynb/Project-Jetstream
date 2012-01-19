<?php
$command = $_SERVER['argv'][1];
$param = $_SERVER['argv'][2];
$start_dir = getcwd() . '/core/cli';
$source_dir = getcwd() . '/apps/demo/';
$dest_dir = getcwd() . '/apps/';

switch ( $command ) {
	case 'make-app':
		$app_name = $param;
		$apps = realpath(__DIR__ . '/../../apps');
		chdir($apps);
		if ( !is_dir($app_name) ) {
			echo "\n\t" . 'Creating app "' . $app_name . '"...';
			copyr($source_dir, $dest_dir . $app_name);

			echo "done! \n\n";
		} else {
			echo "\n\t" . 'Folder "' . $app_name . '" already exists!' . "\n\n";
		}
		break;
}

function copyr($source, $dest) {
	// Simple copy for a file
	if ( is_file($source) ) {
		$c = copy($source, $dest);
		chmod($dest, 0777);
		return $c;
	}

	// Make destination directory
	if ( !is_dir($dest) ) {
		$oldumask = umask(0);

		// if dir is "BUILD-ID" create a timestamp instead
		if ( strpos($dest, 'BUILD-ID') !== false ) {
			$dest = str_replace('BUILD-ID', date("YmdHi"), $dest);
		}
		mkdir($dest, 0777);
		umask($oldumask);
	}

	// Loop through the folder
	$dir = dir($source);
	while ( false !== $entry = $dir->read() ) {
		// Skip pointers
		if ( $entry == "." || $entry == ".." ) {
			continue;
		}

		// Deep copy directories
		$s = $source . '/' . $entry;
		if ( $dest !== $s ) {
			$s = $source . '/' . $entry;
			$d = $dest . '/' . $entry;
			copyr($s, $d);
		}
	}

	// Clean up
	$dir->close();
	return true;
}
