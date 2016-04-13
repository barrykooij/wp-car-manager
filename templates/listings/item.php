<li class="wpcm-listings-item">
	<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
		<?php do_action( 'wpcm_vehicle_listings_item_start', $vehicle ); ?>
		<div class="wpcm-listings-item-image-wrapper">
			<?php do_action( 'wpcm_vehicle_listings_item_image_start', $vehicle ); ?>
			<?php echo $image; ?>
			<?php do_action( 'wpcm_vehicle_listings_item_image_end', $vehicle ); ?>
		</div>
		<div class="wpcm-listings-item-description">
			<?php do_action( 'wpcm_vehicle_listings_item_description_start', $vehicle ); ?>
			<h3><?php echo $title; ?></h3>
			<p><?php echo $description; ?></p>
			<?php do_action( 'wpcm_vehicle_listings_item_description_end', $vehicle ); ?>
		</div>
		<div class="wpcm-listings-item-meta">
			<?php do_action( 'wpcm_vehicle_listings_item_meta_start', $vehicle ); ?>
			<ul>
				<li class="wpcm-title"><?php echo $title; ?></li>
				<li class="wpcm-price"><?php echo $price; ?></li>
				<li><?php echo $mileage; ?></li>
				<li><?php echo $frdate; ?></li>
			</ul>
			<?php do_action( 'wpcm_vehicle_listings_item_meta_end', $vehicle ); ?>
		</div>
		<?php do_action( 'wpcm_vehicle_listings_item_end', $vehicle ); ?>
	</a>
</li>