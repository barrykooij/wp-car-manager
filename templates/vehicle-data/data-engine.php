<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Engine', 'wp-car-manager' ); ?></th>
	<td><span itemprop="vehicleEngine" class="wpcm-vehicle-data"><?php echo $vehicle->get_engine(); ?></span></td>
</tr>
