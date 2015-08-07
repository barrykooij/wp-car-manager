<?php

namespace Never5\WPCarManager\Ajax;

class GetVehiclesListings extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'get_vehicles_listings' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// @todo set filters
		$filters = array();

		// get vehicles
		$vehicles = wp_car_manager()->service( 'vehicle_manager' )->get_vehicles( $filters );

		// check & loop
		if ( count( $vehicles ) > 0 ) {
			foreach ( $vehicles as $vehicle ) {

				// load template
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/item', '', array(
					'title' => get_the_title( $vehicle->get_id() ),
				) );
			}
		}

		// bye
		exit;
	}


}