<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;


// find getter dynamically
$method = ( method_exists( $vehicle, 'get_' . $key ) ) ? 'get_' . $key : null;
?>
<tr>
	<th><?php echo ucfirst( $key ); ?></th>
	<td><span class="wpcm-vehicle-data"><?php echo( ( null !== $method ) ? $vehicle->$method() : '' ); ?></span> <small>NOT OVERRIDDEN( <?php print_r($key); ?> )</small></td>
</tr>
