<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Make', 'wp-car-manager' ); ?></th>
	<td><span itemprop="manufacturer" class="wpcm-vehicle-data"><?php echo $vehicle->get_make_name(); ?></span>
	</td>
</tr>
