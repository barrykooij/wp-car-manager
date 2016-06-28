<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Color', 'wp-car-manager' ); ?></th>
	<td><span itemprop="color" class="wpcm-vehicle-data"><?php echo $vehicle->get_color(); ?></span></td>
</tr>
