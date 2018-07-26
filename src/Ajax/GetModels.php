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

		// check if need to filter out empty makes
		$skip_empty = ( 1 === absint( wp_car_manager()->service( 'settings' )->get_option( 'listings_hide_empty_makes_models' ) ) );

		// check & loop
		if ( count( $models_raw ) > 0 ) {
			foreach ( $models_raw as $model_raw ) {

				// check if we should skip empty models. If we should, check if this model has vehicles attached to it
				if ( $skip_empty ) {
					if ( 0 == wp_car_manager()->service( 'make_model_manager' )->get_vehicle_count( 0, $model_raw['id'] ) ) {
						continue;
					}
				}

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