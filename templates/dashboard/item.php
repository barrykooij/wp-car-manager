<li class="wpcm-dashboard-item" data-id="<?php echo $id; ?>" data-title="<?php echo $title; ?>">

	<?php do_action( 'wpcm_vehicle_dashboard_item_start', $vehicle ); ?>

	<div class="wpcm-dashboard-item-image-wrapper">
		<?php do_action( 'wpcm_vehicle_dashboard_item_image_start', $vehicle ); ?>
		<?php echo $image; ?>
		<?php do_action( 'wpcm_vehicle_dashboard_item_image_end', $vehicle ); ?>
	</div>

	<div class="wpcm-dashboard-item-data">
		<?php do_action( 'wpcm_vehicle_dashboard_item_data_start', $vehicle ); ?>
		<ul>
			<li class="wpcm-title"><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
			<li class="wpcm-price"><?php echo $price; ?></li>
			<li><?php echo $mileage; ?></li>
			<li><?php echo $frdate; ?></li>
		</ul>
		<?php do_action( 'wpcm_vehicle_dashboard_item_data_end', $vehicle ); ?>
	</div>

	<div class="wpcm-dashboard-item-expires">
		<?php do_action( 'wpcm_vehicle_dashboard_item_expires_start', $vehicle ); ?>
		<span class="wpcm-expires-on"><?php _e( 'Expires on', 'wp-car-manager' ); ?></span>
		<strong><?php echo $expires; ?></strong>
		<?php do_action( 'wpcm_vehicle_dashboard_item_expires_end', $vehicle ); ?>
	</div>

	<div class="wpcm-dashboard-item-actions">
		<?php do_action( 'wpcm_vehicle_dashboard_item_actions_start', $vehicle ); ?>
		<ul>
			<?php do_action( 'wpcm_dashboard_item_actions', $vehicle ); ?>
		</ul>
		<?php do_action( 'wpcm_vehicle_dashboard_item_actions_end', $vehicle ); ?>
	</div>

	<?php do_action( 'wpcm_vehicle_dashboard_item_end', $vehicle ); ?>

</li>