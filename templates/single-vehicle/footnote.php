<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$footnote = wp_car_manager()->service( 'settings' )->get_option( 'listings_single_footnote' );
if ( empty( $footnote ) ) {
	return;
}

?>
<div class="wpcm-content-block" id="wpcm-vehicle-footnote">
	<?php echo esc_html( $footnote ); ?>
</div>
