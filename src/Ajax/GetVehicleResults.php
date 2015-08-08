<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class GetVehicleResults extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'get_vehicle_results' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// check nonce
		$this->check_nonce();

		// @todo set filters
		$filters = array();

		// get filters from get vars
		foreach ( $_GET as $get_key => $get_var ) {
			if ( 0 === strpos( $get_key, 'filter_' ) ) {
				$filters[ str_ireplace( 'filter_', '', $get_key ) ] = absint( $get_var );
			}
		}

		// get vehicles
		$vehicle_manager = new Vehicle\Manager();
		$vehicles        = $vehicle_manager->get_vehicles( $filters );

		// check & loop
		if ( count( $vehicles ) > 0 ) {
			foreach ( $vehicles as $vehicle ) {

				// title
				$title = get_the_title( $vehicle->get_id() );

				// get image
				$image = get_the_post_thumbnail( $vehicle->get_id(), apply_filters( 'wpcm_listings_vehicle_thumbnail_size', 'wpcm_vehicle_listings_item' ), array(
					'title' => $title,
					'alt'   => $title,
					'class' => 'wpcm-listings-item-image'
				) );

				// load template
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/item', '', array(
					'url'         => get_permalink( $vehicle->get_id() ),
					'title'       => $title,
					'image'       => $image,
					'description' => $vehicle->get_short_description(),
					'price'       => $vehicle->get_formatted_price(),
					'mileage'     => $vehicle->get_formatted_mileage(),
					'frdate'      => $vehicle->get_frdate()
				) );
			}
		}

		// bye
		exit;
	}

}