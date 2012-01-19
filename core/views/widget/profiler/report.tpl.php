<?php
use jetstream\core\debug\Profiler;

$memory = number_format(round(memory_get_peak_usage() / 1048576, 4), 4);
$time = number_format(round(Profiler::$_end_time - Profiler::$_start_time, 4), 4);


$task_array = array();
foreach ( Profiler::$_tracker[Profiler::$_default_category] as $crumb ) {

	if ( isset($task_array[$crumb['task_id']]) ) {

		if ( $crumb['time'] > $task_array[$crumb['task_id']]['end'] ) {

			$task_array[$crumb['task_id']]['end'] = $crumb['time'];
		}
	} else {
		$task_array[$crumb['task_id']]['title'] = $crumb['title'];
		$task_array[$crumb['task_id']]['comment'] = $crumb['comment'];
		$task_array[$crumb['task_id']]['end'] = $task_array[$crumb['task_id']]['start'] = $crumb['time'];
	}
}
$time_array = array();
$first_block = array_shift($task_array);
foreach ( $task_array as $crumb ) {

	$time_array[] = $crumb['start'] . '|' . $crumb['end'];
}
$time = number_format(round($first_block['end'] - $first_block['start'], 3), 3);
?>

<div class="profiler_container">
	<div class="profiler_body">
		<table class="bordered-table">
			<tr><th colspan="2">APPLICATION PERFORMANCE REPORT</th></tr>
			<tr><td width="200">Peak Memory Usage:</td><td><?php echo $memory; ?> megabytes</td></tr>
			<tr><td width="200">Total App Runtime:</td><td><?php echo $time; ?> seconds</td></tr>
			<tr><th colspan="2">LOAD TIME MARKERS</th></tr>
			<tr><td colspan="2">
					<table class="waterfall">
						<tr>
							<th><?php echo $first_block['title']; ?></th>
							<td><?php echo $time; ?> seconds</td>
						</tr>
						<?php
						foreach ( $task_array as $crumb ) {
							$time = number_format(round($crumb['end'] - $crumb['start'], 4), 4);
							?>
							<tr>
								<th><?php echo $crumb['title']; ?></th>
								<td><?php echo $time; ?> seconds</td>
							</tr>
							<?php
						}
						?>
					</table>
					</div>
				</td></tr>
		</table>
	</div>
</div>