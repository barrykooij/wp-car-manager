<li class="wpcm-dashboard-item" data-id="<?php echo $id; ?>" data-title="<?php echo $title; ?>">

	<?php echo $image; ?>

	<div class="wpcm-dashboard-item-data">
		<ul>
			<li class="wpcm-title"><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
			<li class="wpcm-price"><?php echo $price; ?></li>
			<li><?php echo $mileage; ?></li>
			<li><?php echo $frdate; ?></li>
		</ul>
	</div>

	<div class="wpcm-dashboard-item-expires">
		<span class="wpcm-expires-on"><?php _e( 'Expires on', 'wp-car-manager' ); ?></span>
		<strong><?php echo $expires; ?></strong>
	</div>

	<div class="wpcm-dashboard-item-actions">
		<ul>
			<?php do_action( 'wpcm_dashboard_item_actions', $vehicle ); ?>
		</ul>
	</div>

</li>