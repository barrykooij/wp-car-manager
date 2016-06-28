<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// use Helper namespace in this class, do not remove
use Never5\WPCarManager\Helper;

?>
<tr>
	<th><?php _e( 'Power', 'wp-car-manager' ); ?></th>
	<td><span itemprop="enginePower" class="wpcm-vehicle-data"><?php echo $vehicle->get_power_kw(); ?> <?php echo Helper\Power::label('kw'); ?> (<?php echo $vehicle->get_power_hp(); ?> <?php echo Helper\Power::label('hp'); ?>)</span></td>
</tr>
