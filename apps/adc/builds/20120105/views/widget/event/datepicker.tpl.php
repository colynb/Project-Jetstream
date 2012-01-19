<?php
echo $this->jqueryui->datepicker(array(
	'id' => 'event-date',
	'name' => 'event_date',
	'start_date' => $query['event_date']
));
?>

