<div class="wpcm-notice">
	<h2><?php _e( 'Preview', 'wp-car-manager' ); ?></h2>
	<p><?php _e( 'This is a preview of your listing, please note this listing is not published yet!', 'wp-car-manager' ); ?></p>
	<a href="<?php echo $publish_url; ?>" class="button wpcm-button"><?php echo $publish_label; ?></a>
	<span class="wpcm-preview-or">or</span>
	<a href="<?php echo $edit_url; ?>" class="wpcm-btn-link"><?php _e( 'Edit listing', 'wp-car-manager' ); ?></a>
</div>

<h1><?php echo $vehicle->get_title(); ?></h1>