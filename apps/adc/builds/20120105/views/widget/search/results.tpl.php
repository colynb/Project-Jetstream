<div class="search-results">



	<?php
	foreach ($results as $k => $vars ) {
		echo $this->template('search/results-item',compact('vars'));
	}
	?>

</div>