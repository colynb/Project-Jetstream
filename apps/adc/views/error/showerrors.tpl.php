<?php



$errors = error_get_last();
if ( !is_file($errors['file']) ) {
	return '';
}
$file = file($errors['file']);

switch ( $errors['type'] ) {
	case E_ERROR:
		$type = 'Fatal Error: ';
		break;

	case E_WARNING:
		$type = 'Warning: ';
		break;

	case E_NOTICE:
		$type = 'Notice: ';
		break;

	case E_PARSE:
		$type = 'Parse Error: ';
		break;

	default:
		$type = 'Error: ';
}
$lines = array();
$start = $errors['line'] - 8;

if ( $errors['line'] <= 8 ) {
	$start = 0;
}

for ( $i = $start; $i < $errors['line'] + 8; $i++ ) {
	if ( empty($file[$i]) ) {
		$lines[] = "\n";
	} else {
		$lines[] = $file[$i];
	}
}
?>

<div class="shutdown-error">
	<h1><span class="type"><?= $type ?></span> <span class="message"><?= $errors['message'] ?></span></h1>
	<h3>Found in <?= $errors['file'] ?> on line <?= $errors['line'] ?></h3>
	<div class="shutdown-error-content">
		<pre class="brush:php; highlight: [<?= $errors['line'] ?>]; first-line: <?= $start + 1 ?>;">
			<?= join("", $lines); ?>
		</pre>
	</div>

</div>