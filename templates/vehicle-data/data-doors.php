<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<tr>
	<th><?php _e( 'Doors', 'wp-car-manager' ); ?></th>
	<td><span itemprop="numberOfDoors" class="wpcm-vehicle-data"><?php echo $vehicle->get_doors(); ?></span></td>
</tr>
