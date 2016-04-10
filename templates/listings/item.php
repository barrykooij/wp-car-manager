<li class="wpcm-listings-item">
	<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
		<?php do_action( 'wpcm_vehicle_listings_item_start', $vehicle ); ?>
		<?php echo $image; ?>
		<div class="wpcm-listings-item-description">
			<h3><?php echo $title; ?></h3>
			<p><?php echo $description; ?></p>
		</div>
		<div class="wpcm-listings-item-meta">
			<ul>
				<li class="wpcm-title"><?php echo $title; ?></li>
				<li class="wpcm-price"><?php echo $price; ?></li>
				<li><?php echo $mileage; ?></li>
				<li><?php echo $frdate; ?></li>
			</ul>
		</div>
		<?php do_action( 'wpcm_vehicle_listings_item_end', $vehicle ); ?>
	</a>
</li>