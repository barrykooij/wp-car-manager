<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<div class="wpcm-content-block" id="wpcm-vehicle-content">
	<h2><?php _e( 'Vehicle Description', 'wp-car-manager' ); ?></h2>
	<?php echo apply_filters( 'the_content', $vehicle->get_description() ); ?>
</div>
