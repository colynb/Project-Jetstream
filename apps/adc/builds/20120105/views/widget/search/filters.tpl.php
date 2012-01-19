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



//?Category=Land
//?i=1&q1=real-estate&q2=Commercial&x1=product_vertical&x2=product_category

use jetstream\core\debug\Debug;


?>
<div class="section">
	<h2>Filter your Search</h2>
	<div class="container-padding section-body">



		<?php
		debug::console('refinements', $refinements);
		foreach ( $refinements as $a => $row ) {

			// Don't show vertical
			if ( $row['title'] == 'Product Vertical' ) continue;

			?>
			<h3><?= $row['title'] ?></h3>
			<div class="refinement-section">
				<?php

				foreach ( $row['value'] as $b => $link ) {

					if ( $link['selected'] ) {
						$checked = ' checked="checked"';
						$url = $link['undolink'];
					} else {
						$checked = '';
						$url = $link['link'];
					}

					?>
					<label><input type="checkbox" name="<?= $row['title'] ?>"<?= $checked ?> value="<?= $link['label'] ?>" />&nbsp;<?= $link['label'] ?> (<?= $link['count'] ?>)</label><br />
			<? } ?>
				</select>
			</div>
			<div class="refinement-divider"></div>
<? } ?>


	</div>
</div>