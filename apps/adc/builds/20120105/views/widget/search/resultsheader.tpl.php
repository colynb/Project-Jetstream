<?php

$asset_types = array(
	'all' => 'All Results (132)',
	'presale' => 'Presale (112)',
	'featured' => 'Featured (3)',
	'luxury' => 'Luxury (18)',
);

?>


<ul class="tabs">
	<?php

	foreach ( $asset_types as $id => $label ):
		$class = ($id == $named['property_type']) ? 'active' : '';
		$search_url = $this->route->url('search-type', array('category'=>$named['category'],'property_type'=>$id));
		?>
		<li><a class="<?= $class ?>" href="<?= $search_url ?>"><?= $label ?></a></li>
	<?php endforeach; ?>
</ul>
<div class="search-options">


	<ul class="search-options-section search-view">

		<li class="label">View As</li>
		<li class="selected"><a rel="list" href="#">List</a></li>
		<li><a rel="map" href="#">Map</a></li>

	</ul>


	<ul class="search-options-section search-total-results">
		<li class="label">1 - 16 of 130</li>
	</ul>

	<ul class="search-options-section search-pagination">

		<li class=""><a title="first" href="">first</a></li>
		<li class="selected"><a title="1" href="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">1</a></li>
		<li class=""><a title="2" href="?i=1&amp;location=92602&amp;page=2&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">2</a></li>
		<li class=""><a title="3" href="?i=1&amp;location=92602&amp;page=3&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">3</a></li>
		<li class=""><a title="4" href="?i=1&amp;location=92602&amp;page=4&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">4</a></li>
		<li class=""><a title="5" href="?i=1&amp;location=92602&amp;page=5&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">5</a></li>
		<li class=""><a title="6" href="?i=1&amp;location=92602&amp;page=6&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">6</a></li>
		<li class=""><a title="7" href="?i=1&amp;location=92602&amp;page=7&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">7</a></li>
		<li class=""><a title="8" href="?i=1&amp;location=92602&amp;page=8&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">8</a></li>
		<li class=""><a title="9" href="?i=1&amp;location=92602&amp;page=9&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">9</a></li>
		<li><a title="last" href="?i=1&amp;location=92602&amp;page=9&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;x1=product_vertical&amp;x2=product_category">last</a></li>

	</ul>

	<ul class="search-options-section search-sort-options">

		<li class="label">Sort by</li>
		<select class="search-reload" name="sort">
			<option selected="selected" value="&nbsp;&amp;">Relevance</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=asset_id&amp;x1=product_vertical&amp;x2=product_category">Property ID</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=property_name&amp;x1=product_vertical&amp;x2=product_category">Property Name</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=property_city&amp;x1=product_vertical&amp;x2=product_category">City</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=property_state&amp;x1=product_vertical&amp;x2=product_category">State</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=property_zip&amp;x1=product_vertical&amp;x2=product_category">Zip</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=lot_size&amp;x1=product_vertical&amp;x2=product_category">Lot Size</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=square_footage&amp;x1=product_vertical&amp;x2=product_category">Square Footage</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=relevance&amp;x1=product_vertical&amp;x2=product_category">List Price</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=auction_date&amp;x1=product_vertical&amp;x2=product_category">Auction Date</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=bidding_end_datetime&amp;x1=product_vertical&amp;x2=product_category">Bidding End</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=starting_bid&amp;x1=product_vertical&amp;x2=product_category">Starting Bid</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=year_built&amp;x1=product_vertical&amp;x2=product_category">Year</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=current_price&amp;x1=product_vertical&amp;x2=product_category">Current Bid</option>
			<option value="?i=1&amp;location=92602&amp;proximity_search=1&amp;q=*&amp;q1=real-estate&amp;q2=Commercial&amp;sort=proximity&amp;x1=product_vertical&amp;x2=product_category">Proximity</option>

		</select>


	</ul>


</div>
