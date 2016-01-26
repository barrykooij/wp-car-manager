<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * SINGLE VEHICLE
 */

if ( ! function_exists( 'wpcm_template_vehicle_preview_bar' ) ) {
	function wpcm_template_vehicle_preview_bar() {
		global $vehicle;
		if ( 'preview' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/preview', '', array(
				'edit_url'    => add_query_arg( 'edit', $vehicle->get_id(), Never5\WPCarManager\Helper\Pages::get_page_submit() ),
				'publish_url' => add_query_arg( 'wpcm_publish', $vehicle->get_id(), $vehicle->get_url() )
			) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_pending_bar' ) ) {
	function wpcm_template_vehicle_pending_bar() {
		global $vehicle;
		if ( 'pending' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/pending' );
		}
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_images' ) ) {
	function wpcm_template_vehicle_images() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/image' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_thumbnails' ) ) {
	function wpcm_template_vehicle_thumbnails() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/thumbnails' );
	}
}

if ( ! function_exists( 'wpcm_template_single_price' ) ) {
	function wpcm_template_single_price() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/price' );
	}
}

if ( ! function_exists( 'wpcm_template_single_summary_data' ) ) {
	function wpcm_template_single_summary_data() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/summary-data' );
	}
}

if ( ! function_exists( 'wpcm_template_single_data' ) ) {
	function wpcm_template_single_data() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/data' );
	}
}

if ( ! function_exists( 'wpcm_template_single_content' ) ) {
	function wpcm_template_single_content() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/content' );
	}
}

if ( ! function_exists( 'wpcm_template_single_features' ) ) {
	function wpcm_template_single_features() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/features' );
	}
}

if ( ! function_exists( 'wpcm_template_single_contact' ) ) {
	function wpcm_template_single_contact() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/contact' );
	}
}

/**
 * LISTINGS VEHICLE
 */

if ( ! function_exists( 'wpcm_template_vehicle_listings_sort' ) ) {
	function wpcm_template_vehicle_listings_sort() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/sort' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_nonce' ) ) {
	function wpcm_template_vehicle_listings_filters_nonce() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/nonce' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_make' ) ) {
	function wpcm_template_vehicle_listings_filters_make() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/make' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_model' ) ) {
	function wpcm_template_vehicle_listings_filters_model() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/model' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_price' ) ) {
	function wpcm_template_vehicle_listings_filters_price() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/price' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_frdate' ) ) {
	function wpcm_template_vehicle_listings_filters_frdate() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/frdate' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_mileage' ) ) {
	function wpcm_template_vehicle_listings_filters_mileage() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/mileage' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_button' ) ) {
	function wpcm_template_vehicle_listings_filters_button() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/button' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_start' ) ) {
	function wpcm_template_vehicle_listings_start() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/start' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_end' ) ) {
	function wpcm_template_vehicle_listings_end() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/end' );
	}
}

/**
 ************************ CAR SUBMISSION ************************
 */
if ( ! function_exists( 'wpcm_template_submit_car_form_fields_account_signin' ) ) {
	function wpcm_template_submit_car_form_fields_account_signin() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/account-signin' );
	}
}

if ( ! function_exists( 'wpcm_template_submit_car_form_fields_car_title' ) ) {
	function wpcm_template_submit_car_form_fields_car_title( $vehicle ) {
		?>
		<fieldset class="wpcm-fieldset-title">
			<label for="title"><?php _e( 'Listing Title', 'wp-car-manager' ); ?></label>

			<div class="wpcm-field wpcm-required-field">
				<?php
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/form-fields/text', '', array(
					'field'   => array( 'key' => 'title' ),
					'value'   => $vehicle->get_title(),
					'vehicle' => $vehicle
				) );
				?>
			</div>
		</fieldset>
		<?php
	}
}

if ( ! function_exists( 'wpcm_template_submit_car_form_fields_car_description' ) ) {
	function wpcm_template_submit_car_form_fields_car_description( $vehicle ) {
		?>
		<fieldset class="wpcm-fieldset-title">
			<label for="title"><?php _e( 'Description', 'wp-car-manager' ); ?></label>

			<div class="wpcm-field wpcm-required-field">
				<?php
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/form-fields/textarea', '', array(
					'field'   => array( 'key' => 'description' ),
					'value'   => $vehicle->get_description(),
					'vehicle' => $vehicle
				) );
				?>
			</div>
		</fieldset>
		<?php
	}
}

if ( ! function_exists( 'wpcm_template_submit_car_form_fields_car_data' ) ) {
	function wpcm_template_submit_car_form_fields_car_data( $vehicle ) {

		// get fields
		$fields = Never5\WPCarManager\Vehicle\Data::get_fields();

		if ( ! empty( $fields ) ) :

			?>
			<h2><?php _e( 'Car Data', 'wp-car-manager' ); ?></h2>
			<?php

			foreach ( $fields as $field ) :

				?>
				<fieldset class="wpcm-fieldset-<?php esc_attr_e( $field['key'] ); ?>">
					<label
						for="<?php esc_attr_e( $field['key'] ); ?>"><?php echo $field['label'] . apply_filters( 'wpcm_submit_car_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-car-manager' ) . '</small>', $field ); ?></label>

					<div class="wpcm-field <?php echo $field['required'] ? 'wpcm-required-field' : ''; ?>">
						<?php
						$value = '';

						// check if there's a post set
						if ( ! empty( $_POST['wpcm_submit_car'][ $field['key'] ] ) ) {
							$value = esc_attr( sanitize_text_field( stripslashes( $_POST['wpcm_submit_car'][ $field['key'] ] ) ) );
						}

						// if we don't have a POST, take the vehicle data
						if ( empty( $value ) ) {
							// getter method for value
							$get_method = 'get_' . $field['key'];
							$value      = $vehicle->$get_method();

							if ( 'frdate' === $field['key'] && null !== $value ) {
								$value = $value->format( 'Y-m-d' );
							}
						}


						wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/form-fields/' . $field['type'], '', array(
							'field'   => $field,
							'value'   => $value,
							'vehicle' => $vehicle
						) );
						?>
					</div>
				</fieldset>
				<?php

			endforeach;
		endif;

	}
}

if ( ! function_exists( 'wpcm_template_submit_car_form_fields_car_features' ) ) {
	function wpcm_template_submit_car_form_fields_car_features() {


		// get features
		$features = apply_filters( 'wpcm_submit_car_form_features', get_terms( \Never5\WPCarManager\Taxonomies::FEATURES, array(
			'hide_empty' => false
		) ) );

		// check if there are features
		if ( ! empty( $features ) && ! is_wp_error( $features ) ) {

			// load template file
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/car-features', '', array(
				'features' => $features
			) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_submit_car_form_fields_car_images' ) ) {
	function wpcm_template_submit_car_form_fields_car_images( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/images', '', array(
			'vehicle' => $vehicle
		) );
	}
}