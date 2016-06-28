<?php if ( is_user_logged_in() ) : ?>

	<fieldset class="wpcm-fieldset-account">
		<label><?php _e( 'Your account', 'wp-car-manager' ); ?></label>

		<div class="wpcm-field wpcm-account-sign-in">
			<?php
			$user = wp_get_current_user();
			printf( __( 'You are currently signed in as <strong>%s</strong>.', 'wp-car-manager' ), $user->user_login );
			?>

			<a class="button wpcm-button"
			   href="<?php echo apply_filters( 'wpcm_submit_car_form_account_logout_url', wp_logout_url( get_permalink() ) ); ?>"><?php _e( 'Sign out', 'wp-car-manager' ); ?></a>
		</div>
	</fieldset>

<?php else :
	$account_creation             = ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_creation' ) );
	$generate_username_from_email = ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_username' ) );
	?>
	<fieldset class="wpcm-fieldset-account">
		<label><?php _e( 'Have an account?', 'wp-car-manager' ); ?></label>

		<div class="wpcm-field wpcm-account-sign-in">
			<a class="button"
			   href="<?php echo apply_filters( 'wpcm_submit_car_form_account_login_url', wp_login_url( get_permalink() ) ); ?>"><?php _e( 'Sign in', 'wp-car-manager' ); ?></a>

			<?php if ( $account_creation ) : ?>

				<p><?php _e( 'If you don&rsquo;t have an account you can create one below by entering your email address/username. Your account details will be confirmed via email.', 'wp-car-manager'  ); ?></p>

			<?php else : ?>

				<?php echo apply_filters( 'wpcm_submit_car_form_account_login_required_message', __( 'You must sign in to create a new listing.', 'wp-car-manager' ) ); ?>

			<?php endif; ?>
		</div>
	</fieldset>
	<?php if ( $account_creation ) : ?>
	<?php if ( ! $generate_username_from_email ) : ?>
		<fieldset>
			<label for="create_account_username"><?php _e( 'Username', 'wp-car-manager' ); ?></label>

			<div class="wpcm-field wpcm-required-field">
				<?php
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/form-fields/text', '', array(
					'field' => array( 'key' => 'create_account_username' ),
					'value' => ( empty( $_POST['wpcm_submit_car']['create_account_username'] ) ? '' : esc_attr( sanitize_text_field( stripslashes( $_POST['wpcm_submit_car']['create_account_username'] ) ) ) )
				) );
				?>
			</div>
		</fieldset>
	<?php endif; ?>
	<fieldset>
		<label for="create_account_email"><?php _e( 'Your Email', 'wp-car-manager' ); ?></label>

		<div class="wpcm-field wpcm-required-field">
			<?php
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/form-fields/text', '', array(
				'field' => array( 'key' => 'create_account_email' ),
				'value' => ( empty( $_POST['wpcm_submit_car']['create_account_email'] ) ? '' : esc_attr( sanitize_text_field( stripslashes( $_POST['wpcm_submit_car']['create_account_email'] ) ) ) )
			) );
			?>
		</div>
	</fieldset>
<?php endif; ?>

<?php endif; ?>