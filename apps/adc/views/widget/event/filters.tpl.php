<?php

$asset_types = array(
	'all' => 'Any type',
	'bank-owned' => 'Bank Owned',
	'foreclsoure-trustee' => 'Foreclosure/Trustee',
	'residential' => 'Residential',
	'commercial' => 'Commercial',
	'notes' => 'Notes',
	'land' => 'Land',
);

?>
<div class="section">
	<h2>Filter your Search</h2>
	<div class="container-padding section-body">
		<h3>Property Type</h3>
		<?php foreach ( $asset_types as $value => $label ):
			$selected = ($value == $query['property_type'] ) ? 'checked="checked"' : '';
			?>
			<label><input type="radio" name="property_type" value="<?=$value?>" <?=$selected?> /> <?=$label?></label>
		<?php endforeach; ?>

		<h3>Event Date</h3>
			<?=$this->widget('Event::datepicker',compact('named','query'))?>


	</div>
</div>