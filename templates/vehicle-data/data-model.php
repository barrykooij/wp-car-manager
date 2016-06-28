<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Model', 'wp-car-manager' ); ?></th>
	<td><span itemprop="model" class="wpcm-vehicle-data"><?php echo $vehicle->get_model_name(); ?></span>
	</td>
</tr>
