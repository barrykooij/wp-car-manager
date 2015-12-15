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

		// check nonce
		$this->check_nonce();

		// check if vehicle ID is set
		if ( ! isset( $_POST['vehicle_id'] ) ) {
			return;
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
			return;
		}

		// if user is not logged in but allowed to post, we need to create an account
		if ( ! is_user_logged_in() ) {
			// @todo create account
			// @todo login user
		}

		// @todo check if we need to create an account

		// get logged in user
		$user = wp_get_current_user();

		// make sure we've got a logged in user, if we don't something went horribly wrong
		if ( false === $user ) {
			return;
		}

		// check if data is posted
		if ( ! isset( $_POST['data'] ) ) {
			return;
		}

		// parse post data
		parse_str( $_POST['data'], $post_arr );

		// put data in $data
		$data = $post_arr['wpcm_submit_car'];

		error_log( print_r( $data, 1 ), 0 );

		// validate data
		// @todo validate data

		/**
		 * Data Validation
		 */
		try {
			$frdate_dt = new \DateTime( $data['frdate'] );
		} catch ( \Exception $e ) {
			$return['errors'] = array(
				'id'  => 'frdate',
				'msg' => __( 'Incorrect First Registration Date format' )
			);
		}

		// only proceed if errors is empty
		if ( empty( $return['errors'] ) ) {

			// @todo escape data

			/**
			 * Data Sanitation
			 */

			// @todo save data

			// create Vehicle object
			/** @var Vehicle\Car $vehicle */
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( 0 );

			// set vehicle listing author
			$vehicle->set_author( $user->ID );

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
				$return['errors'] = array(
					'id'  => 'persist',
					'msg' => $e->getMessage()
				);
			}

		}

		// send JSON
		wp_send_json( $return );

		// bye
		exit;
	}

}