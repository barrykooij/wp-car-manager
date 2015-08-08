<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class GetModels extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'get_models' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// check nonce
		$this->check_nonce();

		// check if make is set
		if ( ! isset( $_GET['make'] ) ) {
			return;
		}

		// make
		$make = absint( $_GET['make'] );

		// models array
		$models = array();

		// get raw models
		$models_raw = wp_car_manager()->service( 'make_model_manager' )->get_models( $make );

		// check & loop
		if ( count( $models_raw ) > 0 ) {
			foreach ( $models_raw as $model_raw ) {

				// add to $models array
				$models[] = array( 'id' => $model_raw['id'], 'name' => $model_raw['name'] );
			}
		}

		// send JSON
		wp_send_json( $models );

		// bye
		exit;
	}

}