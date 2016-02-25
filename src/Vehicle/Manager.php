<?php

namespace Never5\WPCarManager\Vehicle;

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
	 * - condition (new,used)
	 *
	 * Sort possibilities:
	 * - price-asc
	 * - price-desc
	 * - year-asc
	 * - year-desc
	 * - mileage-asc
	 * - mileage-desc
	 *
	 * @param array $filters
	 * @param string $sort
	 * @param int $per_page
	 * @param array $extra_args
	 *
	 * @return array
	 */
	public function get_vehicles( $filters, $sort, $per_page = - 1, $extra_args = array() ) {

		// vehicle array
		$vehicles = array();

		// translate $sort to \WP_Query sort
		$sort_params = explode( '-', $sort );
		$order       = ( 'desc' == array_pop( $sort_params ) ) ? 'DESC' : 'ASC';
		$sort_val    = array_shift( $sort_params );
		$meta_key    = 'wpcm_' . $sort_val;
		switch ( $sort_val ) {
			case 'price':
				$meta_type = 'NUMERIC';
				break;
			case 'frdate':
				$meta_type = 'DATE';
				break;
			case 'mileage':
				$meta_type = 'NUMERIC';
				break;
		}

		// \WP_Query arg
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => PostType::VEHICLE,
			'posts_per_page' => $per_page,
			'orderby'        => 'meta_value',
			'order'          => $order,
			'meta_type'      => $meta_type,
			'meta_key'       => $meta_key
		);

		// base meta query
		$meta_query = array();


		// check for make
		if ( is_array( $filters ) && count( $filters ) > 0 ) {
			foreach ( $filters as $filter_key => $filter_val ) {

				// var that will contain filter specific values
				$key     = '';
				$compare = '=';
				$type    = 'NUMERIC';

				switch ( $filter_key ) {

					// check for make and model filter
					case 'make':
					case 'model':
						$key        = 'wpcm_' . $filter_key;
						$filter_val = absint( $filter_val );
						break;
					case 'price_from':
					case 'mileage_from':
					case 'frdate_from':
						$key        = 'wpcm_' . str_ireplace( '_from', '', $filter_key );
						$compare    = '>=';
						$filter_val = absint( $filter_val );
						break;
					case 'price_to':
					case 'mileage_to':
					case 'frdate_to':
						$key        = 'wpcm_' . str_ireplace( '_to', '', $filter_key );
						$compare    = '<=';
						$filter_val = absint( $filter_val );
						break;
					case 'condition':
						$key        = 'wpcm_condition';
						$filter_val = sanitize_title( $filter_val );
						$type       = 'CHAR';
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
						'type'    => $type
					);
				}

			}
		}

		// check if there's a meta query
		if ( count( $meta_query ) > 0 ) {

			// add meta query
			$args['meta_query'] = $meta_query;

		}

		// merge extra args
		if ( ! empty( $extra_args ) ) {
			$args = array_merge( $args, $extra_args );
		}

		// do new \WP_Query
		$vehicle_query = new \WP_Query( $args );

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

	/**
	 * Mark published vehicles that has expired as expired
	 *
	 * @return bool
	 */
	public function mark_vehicles_expired() {

		$today = new \DateTime();
		$today->setTime( 0, 0, 0 );

		// query
		$expired_query = new \WP_Query( array(
			'post_status'    => 'publish',
			'post_type'      => PostType::VEHICLE,
			'posts_per_page' => - 1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'     => 'wpcm_expiration',
					'value'   => $today->format( 'Y-m-d' ),
					'type'    => 'DATE',
					'compare' => '<='
				)
			)
		) );

		// check & loop
		if ( $expired_query->have_posts() ) {
			while ( $expired_query->have_posts() ) {

				// load next
				$expired_query->the_post();

				// update the post status
				wp_update_post( array(
					'ID'          => get_the_ID(),
					'post_status' => 'expired'
				) );
			}
		}

		// reset post data
		wp_reset_postdata();

		return true;
	}


}