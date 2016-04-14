<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<tr>
	<th><?php _e( 'Condition', 'wp-car-manager' ); ?></th>
	<td><span itemprop="itemCondition" class="wpcm-vehicle-data"><?php echo $vehicle->get_formatted_condition(); ?></span></td>
</tr>
