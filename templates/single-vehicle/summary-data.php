<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$summary_data = Never5\WPCarManager\Vehicle\Data::remove_empty_fields( wp_car_manager()->service( 'settings' )->get_option( 'summary_data' ), $vehicle );

?>
<div class="wpcm-summary-data">

	<table>
	<?php foreach ( $summary_data  as $data_key ) : ?>
		<?php wp_car_manager()->service( 'template_manager' )->get_template_part( 'vehicle-data/data', $data_key, array( 'key' => $data_key, 'vehicle' => $vehicle ) ); ?>
	<?php endforeach; ?>
	</table>

</div>