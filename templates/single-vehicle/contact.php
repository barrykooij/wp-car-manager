<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<div class="wpcm-contact">

	<?php
	if ( '' != $email && apply_filters( 'wpcm_contact_email_link', true ) ) :
		?>
		<a href="mailto:<?php echo antispambot( $email ); ?>?subject=<?php the_title(); ?>"
		   class="wpcm-button wpcm-contact-button"><?php _e( 'Email Us', 'wp-car-manager' ); ?></a>
	<?php endif; ?>

	<?php
	if ( '' !== $phone_number && apply_filters( 'wpcm_contact_phone_link', true ) ) :
		?>
		<a href="tel:<?php echo esc_attr( $phone_number ); ?>"
		   class="wpcm-button wpcm-contact-button"><?php _e( 'Call Us', 'wp-car-manager' ); ?></a>
	<?php endif; ?>

</div>