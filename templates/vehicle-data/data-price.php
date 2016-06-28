<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Price', 'wp-car-manager' ); ?></th>
	<td><span class="wpcm-vehicle-data"><?php echo $vehicle->get_formatted_price(); ?></span>
	</td>
</tr>
