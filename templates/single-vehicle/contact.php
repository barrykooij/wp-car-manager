<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


global $vehicle;

?>
<div class="wpcm-contact">

	<?php
	$email = wp_car_manager()->service( 'settings' )->get_option( 'contact_email' );
	if ( '' != $email ) :
		?>
		<a href="mailto:<?php echo antispambot( $email ); ?>?subject=<?php the_title(); ?>"
		   class="wpcm-contact-button"><?php _e( 'Email Us', 'wp-car-manager' ); ?></a>
	<?php endif; ?>

	<?php
	$phone_number = wp_car_manager()->service( 'settings' )->get_option( 'contact_phone' );
	if ( '' !== $phone_number ) :
		?>
		<a href="tel:<?php echo esc_attr( $phone_number ); ?>"
		   class="wpcm-contact-button"><?php _e( 'Call Us', 'wp-car-manager' ); ?></a>
	<?php endif; ?>

</div>