<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<div class="wpcm-content-block">
	<h2><?php _e( 'Vehicle Details', 'wp-car-manager' ); ?></h2>
	<table>
		<?php foreach ( Never5\WPCarManager\Vehicle\Data::get_fields() as $data_key => $data_field ) : ?>
			<?php wp_car_manager()->service( 'template_manager' )->get_template_part( 'vehicle-data/data', $data_key, array( 'key' => $data_key ) ); ?>
		<?php endforeach; ?>
	</table>
</div>
