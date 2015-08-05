<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<tr>
	<th><?php _e( 'Mileage', 'wp-car-manager' ); ?></th>
	<td><span itemprop="mileageFromOdometer" class="wpcm-vehicle-data"><?php echo $vehicle->get_formatted_mileage(); ?></span>
	</td>
</tr>
