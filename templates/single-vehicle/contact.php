<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


global $vehicle;

?>
<div class="wpcm-contact">

	<a href="mailto:<?php echo antispambot( wp_car_manager()->service( 'settings' )->get_option( 'contact_email' ) ); ?>?subject=<?php the_title(); ?>" class="wpcm-contact-button"><?php _e( 'Email Us', 'wp-car-manager' ); ?></a>
	<?php
	$phone_number = wp_car_manager()->service( 'settings' )->get_option( 'contact_phone' );
	if( '' !== $phone_number ) :
	?>
		<a href="tel:<?php echo esc_attr( $phone_number ); ?>" class="wpcm-contact-button"><?php _e( 'Call Us', 'wp-car-manager' ); ?></a>
	<?php endif; ?>

</div>