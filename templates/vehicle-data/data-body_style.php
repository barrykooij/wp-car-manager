<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Body Style', 'wp-car-manager' ); ?></th>
	<td><span class="wpcm-vehicle-data"><?php echo $vehicle->get_body_style(); ?></span></td>
</tr>