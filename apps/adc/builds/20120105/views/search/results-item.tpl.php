<div class="section-panel search-result" data-lat_lng='{"lat":"<?= $vars['LATITUDE']['value'] ?>", "lng": "<?= $vars['LONGITUDE']['value'] ?>"}'>


	<h2>
		<div class="marker" data="location"></div>
		<?php if ( isset($vars['DISTANCE']['value']) ): ?>
			<div class="distance"><?= $vars['DISTANCE']['value'] ?></div>
		<?php endif; ?>
		<a href="/real-estate/auction/<?= $vars['ASSET_ID']['value'] ?>"><?= ($vars['PROPERTY_NAME']['value'] != '') ? $vars['PROPERTY_NAME']['value'] : $vars['PROPERTY_CITY']['value'] . ', ' . $vars['PROPERTY_STATE']['value'] ?></a>
	</h2>

	<div class="section-panel-body clearfix">
		<div class="product-style">
			<div class="product-image">
				<?php
				$img = $vars['ASSET_IMAGES']['value'];
				$error = $this->static->path('/img/assets/no-image147x109.jpg');
				if ( empty($img) ) {
					$img = $error;
				}
				?>
				<a href="/real-estate/auction/<?= $vars['ASSET_ID']['value'] ?>">
					<img src="<?= $img ?>" alt="<?= $vars['PROPERTY_NAME']['value'] ?>" onerror="this.src='<?= $error ?>';" />
				</a>
			</div>
			<div class="product-info">
				<p><span class="start-bid">Starting Bid : $ <?= $vars['STARTING_BID']['value'] ?></span></p>
				<p><span>3 Bedroom, 3 Bath</span> | <?= $vars['SQUARE_FOOTAGE']['value'] ?> Sq Ft | <?= $vars['LOT_SIZE']['value'] ?> lot size</p>
				<p><span class="numbers">Item#: 12345   Property ID: <?= $vars['ASSET_ID']['value'] ?>   TS NUMBER: <?= $vars['EVENT_ID']['value'] ?>-456</span></p>
				<p><span>Auction Start:</span><span class="date"> <?= $vars['EVENT_DATE']['value'] ?> </span> <!--<span>0 bids</span>--></p>

				<p>
					<a href="/real-estate/auction/<?= $vars['ASSET_ID']['value'] ?>" class="btn search small">More Details</a>
					<a href="#" class="btn small">Save</a>
					<a href="#" class="btn small">Share</a>
				</p>

			</div>
		</div>
	</div>

</div>