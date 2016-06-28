<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class SaveVehicle extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'save_vehicle' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// return fields
		$return = array( 'success' => false, 'errors' => array(), 'vehicle' => 0 );

		try {

			// check nonce
			$this->check_nonce();

			// check if vehicle ID is set
			if ( ! isset( $_POST['vehicle_id'] ) ) {
				throw new SaveVehicleException( __( 'Missing vehicle ID.', 'wp-car-manager' ), 'missing-id' );
			}

			// vehicle ID (can be 0 for new vehicle)
			$vehicle_id = absint( $_POST['vehicle_id'] );

			// check if user is logged in and allowed to do this
			$is_allowed = false;
			if ( 0 == $vehicle_id ) {
				$is_allowed = wp_car_manager()->service( 'user_manager' )->can_post_listing();
			} else {
				$is_allowed = wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id );
			}

			// requester not allowed to do what they try to do
			if ( true != $is_allowed ) {
				throw new SaveVehicleException( __( 'Not allowed to create/edit vehicle.', 'wp-car-manager' ), 'not-allowed' );
			}

			// check if data is posted
			if ( ! isset( $_POST['data'] ) ) {
				throw new SaveVehicleException( 'No data received', 'no-data' );
			}

			// parse post data
			parse_str( $_POST['data'], $post_arr );

			// put data in $data
			$data = $post_arr['wpcm_submit_car'];

			// if user is not logged in but allowed to post, we need to create an account
			if ( ! is_user_logged_in() ) {

				$new_account_id = null;

				// check if account creation is allowed
				if ( wp_car_manager()->service( 'user_manager' )->is_account_creation_allowed() ) {

					// username must be posted when not automatically generated from email address
					if ( ! wp_car_manager()->service( 'user_manager' )->is_generate_username_from_email() && empty( $data['create_account_username'] ) ) {
						throw new SaveVehicleException( __( 'Please enter a username.', 'wp-car-manager' ), 'missing-username' );
					}

					// if user is not logged in and automatic account creation is enabled we do require an email address
					if ( empty( $data['create_account_email'] ) ) {
						throw new SaveVehicleException( __( 'Please enter your email address.', 'wp-car-manager' ), 'missing-email' );
					}

					// create account
					$new_account_id = wp_car_manager()->service( 'user_manager' )->create_account( array(
						'username' => ( wp_car_manager()->service( 'user_manager' )->is_generate_username_from_email() ? '' : $data['create_account_username'] ),
						'email'    => $data['create_account_email'],
						'role'     => wp_car_manager()->service( 'user_manager' )->get_registration_role()
					) );

				}

				// check if account was created
				if ( is_wp_error( $new_account_id ) ) {
					throw new SaveVehicleException( $new_account_id->get_error_message(), 'account-creation-failed' );
				}

				// login new account
				if ( null !== $new_account_id ) {
					wp_car_manager()->service( 'user_manager' )->login_user( $new_account_id );
				}
			}

			// get logged in user
			$user = wp_get_current_user();

			// make sure we've got a logged in user, if we don't something went horribly wrong
			if ( false === $user ) {
				throw new SaveVehicleException( __( 'User could not log in, please contact support.', 'wp-car-manager' ), 'account-login-failed' );
			}

			// validate data

			/**
			 * Data Validation
			 */
			try {
				$frdate_dt = new \DateTime( $data['frdate'] );
			} catch ( \Exception $e ) {
				throw new SaveVehicleException( __( 'Incorrect First Registration Date format', 'wp-car-manager' ), 'frdate' );
			}

			/**
			 * Data Sanitation
			 */

			// Sanitize integer values
			$data['mileage'] = intval( preg_replace( '/,|\./mi', '', $data['mileage'] ) );
			$data['price']   = intval( preg_replace( '/,|\./mi', '', $data['price'] ) );
			$data['doors']   = intval( $data['doors'] );

			// create Vehicle object
			/** @var Vehicle\Car $vehicle */
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $vehicle_id );

			// set some intial data for new vehicles
			if ( 0 == $vehicle->get_id() ) {

				// set vehicle status to preview if this is a new item
				$vehicle->set_status( 'preview' );

				// set vehicle listing author
				$vehicle->set_author( $user->ID );
			}

			// set Vehicle data in object
			$vehicle->set_title( $data['title'] );
			$vehicle->set_description( $data['description'] );
			$vehicle->set_condition( $data['condition'] );
			$vehicle->set_make( $data['make'] );
			$vehicle->set_model( $data['model'] );
			$vehicle->set_frdate( $frdate_dt );
			$vehicle->set_price( $data['price'] );
			$vehicle->set_mileage( $data['mileage'] );
			$vehicle->set_fuel_type( $data['fuel_type'] );
			$vehicle->set_color( $data['color'] );
			$vehicle->set_body_style( $data['body_style'] );
			$vehicle->set_transmission( $data['transmission'] );
			$vehicle->set_engine( $data['engine'] );
			$vehicle->set_doors( $data['doors'] );

			// set features
			if ( isset( $data['features'] ) && count( $data['features'] ) > 0 ) {
				$features = array();
				foreach ( $data['features'] as $feature_id ) {
					$features[ $feature_id ] = 'n/a';
				}
				$vehicle->set_features( $features );
			}

			try {

				// try to persist vehicle
				$vehicle = wp_car_manager()->service( 'vehicle_repository' )->persist( $vehicle );

				// set success to true in return
				$return['success'] = true;

				// set vehicle ID in return
				$return['vehicle'] = $vehicle->get_id();

			} catch ( \Exception $e ) {
				throw new SaveVehicleException( $e->getMessage(), 'persist' );
			}


		} catch ( SaveVehicleException $e ) {
			$return['success'] = false;
			$return['errors']  = array(
				'id'  => $e->getId(),
				'msg' => $e->getMessage()
			);
		}

		// send JSON
		wp_send_json( $return );

		// bye
		exit;
	}

}