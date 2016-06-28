<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Transmission', 'wp-car-manager' ); ?></th>
	<td><span itemprop="vehicleTransmission" class="wpcm-vehicle-data"><?php echo $vehicle->get_formatted_transmission(); ?></span></td>
</tr>
