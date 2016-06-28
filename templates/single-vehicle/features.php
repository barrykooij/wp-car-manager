<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// get features
$features = $vehicle->get_features();

if ( count( $features ) > 0 ) : ?>
	<div class="wpcm-content-block" id="wpcm-vehicle-features">
		<h2><?php _e( 'Vehicle Features', 'wp-car-manager' ); ?></h2>
		<ul>
			<?php foreach ( $features as $feature ) : ?>
				<li><?php echo $feature; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>