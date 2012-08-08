<?php
$this->queue('css', array('src' => '/css/base/bootstrap.min.css'));
$this->queue('css', array('src' => '/css/profiler.css'));
$this->queue('js', array('src' => '/js/jquery.min.js'));
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>jetstream</title>

<?= $this->widget('html::js') ?>

<?= $this->widget('html::css') ?>

	</head>

	<body>
		<div class="container">
			<?= $this->buffer('template') ?>
		</div>
    </body>


</html>



