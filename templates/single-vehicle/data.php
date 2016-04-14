<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<div class="wpcm-content-block" id="wpcm-vehicle-data">
	<h2><?php _e( 'Vehicle Details', 'wp-car-manager' ); ?></h2>
	<?php

	// get fields
	$fields = Never5\WPCarManager\Vehicle\Data::remove_empty_fields( array_map( function ( $f ) {
		return $f['key'];
	}, Never5\WPCarManager\Vehicle\Data::get_fields() ), $vehicle );

	// make fields displayed on single vehicle filterable
	$fields = apply_filters( 'wpcm_single_vehicle_data_fields', $fields, $vehicle );

	// split fields into 2 arrays
	$tables = array_chunk( $fields, ( ceil( count( $fields ) / 2 ) ) );
	?>

	<?php foreach ( $tables as $table_fields ) : ?>
		<table>
			<?php foreach ( $table_fields as $data_key => $data_field ) : ?>
				<?php wp_car_manager()->service( 'template_manager' )->get_template_part( 'vehicle-data/data', $data_field, array( 'key' => $data_field, 'vehicle' => $vehicle ) ); ?>
			<?php endforeach; ?>
		</table>
	<?php endforeach; ?>
</div>
