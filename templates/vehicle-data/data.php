<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// find getter dynamically
$method = ( method_exists( $vehicle, 'get_' . $key ) ) ? 'get_' . $key : null;
?>
<tr>
	<th><?php echo ucfirst( $key ); ?></th>
	<td><span class="wpcm-vehicle-data"><?php echo( ( null !== $method ) ? $vehicle->$method() : '' ); ?></span><?php echo( current_user_can( 'manage_options' ) ? ' <small>NOT OVERRIDDEN( ' . print_r( $key, true ) . ' )</small>' : '' ); ?>
	</td>
</tr>