<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<tr>
	<th><?php _e( 'Power', 'wp-car-manager' ); ?></th>
	<td><span itemprop="enginePower" class="wpcm-vehicle-data"><?php echo $vehicle->get_power(); ?> <?php echo $vehicle->get_formatted_power_type(); ?></span></td>
</tr>
