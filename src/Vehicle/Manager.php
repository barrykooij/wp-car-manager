<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\PostType;

class Manager {

	/**
	 * Get vehicles
	 *
	 * Filter possibilities:
	 * - make (int)
	 * - model (int)
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

		// base meta query
		$meta_query = array();

		// check for make
		if ( is_array( $filters ) && count( $filters ) > 0 ) {
			foreach ( $filters as $filter_key => $filter_val ) {

				// var that will contain filter specific values
				$key     = '';
				$compare = '=';

				switch ( $filter_key ) {

					// check for make and model filter
					case 'make':
					case 'model':
						$key = 'wpcm_' . $filter_key;
						break;
					case 'price_from':
					case 'mileage_from':
					case 'frdate_from':
						$key     = 'wpcm_' . str_ireplace( '_from', '', $filter_key );
						$compare = '>=';
						break;
					case 'price_to':
					case 'mileage_to':
					case 'frdate_to':
						$key     = 'wpcm_' . str_ireplace( '_to', '', $filter_key );
						$compare = '<=';
						break;
					default:
						break;

				}

				// check if we've got a new filter
				if ( '' !== $key ) {

					// add new filter
					$meta_query[] = array(
						'key'     => $key,
						'value'   => $filter_val,
						'compare' => $compare,
						'type'    => 'NUMERIC'
					);
				}

			}
		}

		// check if there's a meta query
		if ( count( $meta_query ) > 0 ) {

			error_log( print_r( $meta_query, 1 ), 0 );

			// add meta query
			$args['meta_query'] = $meta_query;

		}

		// do new \WP_Query
		$vehicle_query = new \WP_Query( $args );

		error_log( print_r( $vehicle_query, 1 ), 0 );

		// check
		if ( $vehicle_query->have_posts() ) {

			/** @var VehicleFactory $vehicle_factory */
			$vehicle_factory = wp_car_manager()->service( 'vehicle_factory' );

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