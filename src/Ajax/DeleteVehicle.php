<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class DeleteVehicle extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'delete_vehicle' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// vehicle must be set
		if ( ! isset( $_POST['vehicle'] ) || empty( $_POST['vehicle'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// check nonce
		$this->check_nonce();

		// sanitize variables
		$vehicle_id = absint( $_POST['vehicle'] );

		// check if user is allowed to edit this vehicle
		if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// delete vehicle
		wp_trash_post( $vehicle_id );

		// done
		wp_send_json( array( 'success' => true ) );

		// bye
		exit;
	}

}