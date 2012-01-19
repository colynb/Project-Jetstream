<?php

use jetstream\core\debug\Debug;

if ( !is_array(Debug::$console_log) ) return '';

?>


	<?php

	foreach ( Debug::$console_log as $index => $logs ) {

		?>
<table class="debug-output-table">

		<tr><th>[Console log] <?= $index ?></th></tr>
		<tr><td>

				<?php

		foreach ( $logs as $var ) {

			?>
			<?= $var['dump'] ?><br />
			<?php

		}

		?>

			</td></tr>


				</table>

	<?php

}
?>
