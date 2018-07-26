<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * SINGLE VEHICLE
 */

if ( ! function_exists( 'wpcm_template_vehicle_preview_bar' ) ) {
	function wpcm_template_vehicle_preview_bar( $vehicle ) {
		if ( 'preview' == $vehicle->get_status() ) {

			$wpcm_step = ( ( ! ( empty( $_GET['wpcm_step'] ) ) ? absint( $_GET['wpcm_step'] ) : 0 ) + 1 );

			wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/preview', '', array(
				'edit_url'      => add_query_arg( 'wpcm_vehicle_id', $vehicle->get_id(), Never5\WPCarManager\Helper\Pages::get_page_submit() ),
				'publish_url'   => add_query_arg( array(
					'wpcm_step'       => $wpcm_step,
					'wpcm_vehicle_id' => $vehicle->get_id()
				), Never5\WPCarManager\Helper\Pages::get_page_submit() ),
				'publish_label' => apply_filters( 'wpcm_preview_submit_label', __( 'Submit listing', 'wp-car-manager' ), $vehicle ),
				'vehicle'       => $vehicle
			) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_pending_bar' ) ) {
	function wpcm_template_vehicle_pending_bar( $vehicle ) {
		if ( 'pending' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/pending', '', array( 'vehicle' => $vehicle ) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_expired_bar' ) ) {
	function wpcm_template_vehicle_expired_bar( $vehicle ) {
		if ( 'expired' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/expired', '', array( 'vehicle' => $vehicle ) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_images' ) ) {
	function wpcm_template_vehicle_images( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/image', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_thumbnails' ) ) {
	function wpcm_template_vehicle_thumbnails( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/thumbnails', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_price' ) ) {
	function wpcm_template_single_price( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/price', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_summary_data' ) ) {
	function wpcm_template_single_summary_data( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/summary-data', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_data' ) ) {
	function wpcm_template_single_data( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/data', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_content' ) ) {
	function wpcm_template_single_content( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/content', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_features' ) ) {
	function wpcm_template_single_features( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/features', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_footnote' ) ) {
	function wpcm_template_single_footnote( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/footnote', '', array( 'vehicle' => $vehicle ) );
	}
}

if ( ! function_exists( 'wpcm_template_single_contact' ) ) {
	function wpcm_template_single_contact( $vehicle ) {

		// check if we need to use contact information of the author or the site owner
		if ( 1 === absint( wp_car_manager()->service( 'settings' )->get_option( 'contact_use_car_seller_details' ) ) ) {
			// get email address
			$email = get_user_meta( $vehicle->get_author(), 'wpcm_email', true );

			// get phone number
			$phone_number = get_user_meta( $vehicle->get_author(), 'wpcm_phone', true );
		} else {
			// get email address
			$email = wp_car_manager()->service( 'settings' )->get_option( 'contact_email' );

			// get phone number
			$phone_number = wp_car_manager()->service( 'settings' )->get_option( 'contact_phone' );
		}

		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/contact', '',
			array(
				'vehicle'      => $vehicle,
				'email'        => $email,
				'phone_number' => $phone_number
			)
		);
	}
}

if ( ! function_exists( 'wpcm_template_data_remove_power_hp' ) ) {
	function wpcm_template_data_remove_power_hp( $fields, $vehicle ) {
		unset( $fields['power_hp'] );

		return $fields;
	}
}


/**
 * LISTINGS VEHICLE
 */

if ( ! function_exists( 'wpcm_template_vehicle_listings_sort' ) ) {
	function wpcm_template_vehicle_listings_sort( $atts ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/sort', '', array( 'atts' => $atts ) );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_nonce' ) ) {
	function wpcm_template_vehicle_listings_filters_nonce() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/nonce' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_make' ) ) {
	function wpcm_template_vehicle_listings_filters_make( $atts ) {

		// fetch all makes if make attr is empty
		if ( empty( $atts['make'] ) ) {
			$makes = wp_car_manager()->service( 'make_model_manager' )->get_makes_map();

			// check if need to filter out empty makes
			if ( 1 === absint( wp_car_manager()->service( 'settings' )->get_option( 'listings_hide_empty_makes_models' ) ) ) {
				foreach ( $makes as $make_id => $make_name ) {

					// skip the label
					if ( 0 == $make_id ) {
						continue;
					}

					// unset if no vehicles are in this make
					if ( 0 == wp_car_manager()->service( 'make_model_manager' )->get_vehicle_count( $make_id, 0 ) ) {
						unset( $makes[ $make_id ] );
					}

				}
			}

		} else {
			$term  = get_term_by( 'name', $atts['make'], 'wpcm_make_model' );
			$makes = array( $term->term_id => $term->name );
		}

		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/make', '', array(
			'makes' => $makes
		) );

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

if ( ! function_exists( 'wpcm_template_vehicle_listings_pagination' ) ) {
	function wpcm_template_vehicle_listings_pagination() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/pagination-wrapper' );
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
					'field'   => array( 'key' => 'title', 'placeholder' => __( '', 'wp-car-manager' ) ),
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
					'field'   => array(
						'key'         => 'description',
						'placeholder' => __( 'A short description of the vehicle. Does not need to include features, these can be selected separately below.', 'wp-car-manager' )
					),
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
	function wpcm_template_submit_car_form_fields_car_features( $vehicle ) {


		// get features
		$features = apply_filters( 'wpcm_submit_car_form_features', get_terms( \Never5\WPCarManager\Taxonomies::FEATURES, array(
			'hide_empty' => false
		) ) );

		// check if there are features
		if ( ! empty( $features ) && ! is_wp_error( $features ) ) {

			// get selected features
			$vehicle_features = array_keys( $vehicle->get_features() );


			// load template file
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/car-features', '', array(
				'features'         => $features,
				'vehicle'          => $vehicle,
				'vehicle_features' => $vehicle_features
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

if ( ! function_exists( 'wpcm_template_submit_car_form_disabled' ) ) {
	function wpcm_template_submit_car_form_disabled( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/disabled', '', array(
			'vehicle' => $vehicle
		) );
	}
}

/**
 ************************ DASHBOARD ************************
 */

if ( ! function_exists( 'wpcm_template_dashboard_profile_title' ) ) {
	function wpcm_template_dashboard_profile_title() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/profile-title' );
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_profile' ) ) {
	function wpcm_template_dashboard_profile() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/profile' );
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_list_title' ) ) {
	function wpcm_template_dashboard_list_title() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/list-title' );
	}
}


if ( ! function_exists( 'wpcm_template_dashboard_list_start' ) ) {
	function wpcm_template_dashboard_list_start() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/start' );
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_list_end' ) ) {
	function wpcm_template_dashboard_list_end() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/end' );
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_button_edit' ) ) {
	function wpcm_template_dashboard_button_edit( $vehicle ) {
		if ( in_array( $vehicle->get_status(), array( 'publish', 'pending' ) ) ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/buttons/edit', '', array(
				'vehicle' => $vehicle
			) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_button_delete' ) ) {
	function wpcm_template_dashboard_button_delete( $vehicle ) {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/buttons/delete', '', array(
			'vehicle' => $vehicle
		) );
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_button_renew' ) ) {
	function wpcm_template_dashboard_button_renew( $vehicle ) {
		if ( 'expired' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/buttons/renew', '', array(
				'vehicle' => $vehicle
			) );
		}
	}
}

if ( ! function_exists( 'wpcm_template_dashboard_pagination' ) ) {
	function wpcm_template_dashboard_pagination() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/pagination-wrapper' );
	}
}

/**
 ************************ GENERAL ************************
 */


if ( ! function_exists( 'wpcm_template_sold_sign' ) ) {
	function wpcm_template_sold_sign( $vehicle ) {
		if ( $vehicle->is_sold() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'general/sold-sign' );
		}
	}
}

if ( ! function_exists( 'wpcm_template_review_sign' ) ) {
	function wpcm_template_review_sign( $vehicle ) {
		if ( 'pending' == $vehicle->get_status() ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'general/review-sign' );
		}
	}
}