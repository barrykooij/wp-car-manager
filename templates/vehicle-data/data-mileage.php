<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<tr>
	<th><?php _e( 'Mileage', 'wp-car-manager' ); ?></th>
	<td><span itemprop="mileageFromOdometer" class="wpcm-vehicle-data"><?php echo $vehicle->get_mileage(); ?> <?php echo wp_car_manager()->service( 'settings' )->get( 'distance_unit' ); ?></span>
	</td>
</tr>
