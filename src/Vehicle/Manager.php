<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\PostType;

class Manager {

	/**
	 * Get vehicles
	 *
	 * Filter possibilities:
	 * - make (string)
	 * - model (string)
	 * - price_from (int)
	 * - price_to (int)
	 * - mileage_from (int)
	 * - mileage_to (int)
	 * - frdate_from (int)
	 * - frdate_to (int)
	 *
	 * @param array $filters
	 *
	 * @return array
	 */
	public function get_vehicles( $filters ) {

		// vehicle array
		$vehicles = array();

		// \WP_Query arg
		$args = array(
			'post_type'      => PostType::VEHICLE,
			'posts_per_page' => - 1
		);

		// do new \WP_Query
		$vehicle_query = new \WP_Query( $args );

		// check
		if ( $vehicle_query->have_posts() ) {

			/** @var VehicleFactory $vehicle_factory */
			$vehicle_factory = wp_car_manager()->service('vehicle_factory');

			// loop
			while ( $vehicle_query->have_posts() ) {

				// load next post
				$vehicle_query->the_post();

				// add vehicle to arry
				$vehicles[] = $vehicle_factory->make( get_the_ID() );
			}
		}

		// reset post data
		wp_reset_postdata();

		return $vehicles;
	}

}