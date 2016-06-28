<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Fuel', 'wp-car-manager' ); ?></th>
	<td><span itemprop="fuelType" class="wpcm-vehicle-data"><?php echo $vehicle->get_fuel_type(); ?></span></td>
</tr>
