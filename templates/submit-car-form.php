<?php
/**
 * Car Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form action="<?php echo esc_url( $action ); ?>" method="post" id="wpcm-car-form" class="wpcm-car-form"
      enctype="multipart/form-data">

	<?php if ( apply_filters( 'wpcm_submit_car_form_show_signin', true ) ) : ?>

		<?php do_action( 'wpcm_submit_car_form_login', $vehicle); ?>

	<?php endif; ?>

	<?php if ( $can_post_listing || $can_edit_listing ) : ?>

		<?php do_action( 'wpcm_submit_car_form_fields_start' ); ?>

		<?php do_action( 'wpcm_submit_car_form_fields', $vehicle); ?>

		<?php do_action( 'wpcm_submit_car_form_fields_end' ); ?>

		<p>
			<input type="hidden" name="listing_id" value="<?php echo esc_attr( $vehicle->get_id() ); ?>"/>
			<input type="submit" name="submit_car" class="wpcm-button" value="<?php esc_attr_e( $submit_button_text ); ?>"/>
		</p>

	<?php else : ?>

		<?php do_action( 'wpcm_submit_car_form_disabled' ); ?>

	<?php endif; ?>
</form>