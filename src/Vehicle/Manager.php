<?php

namespace Never5\WPCarManager\Vehicle;

class Manager {

	/** @var \WP_Query */
	private $vehicle_query = null;

	/**
	 * Manager constructor.
	 */
	public function __construct() {
		$this->vehicle_query = new \WP_Query();
	}

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
	 * - hide_sold (bool)
	 *
	 * Sort possibilities:
	 * - price-asc
	 * - price-desc
	 * - year-asc
	 * - year-desc
	 * - mileage-asc
	 * - mileage-desc
	 * - date-asc
	 * - date-desc
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

		// base meta query
		$meta_query = array(
			'relation' => 'AND'
		);

		// translate $sort to \WP_Query sort
		$sort_params = explode( '-', $sort );

		/**
		 * Default first sort entry is menu_order.
		 * This puts 'featured' listings on top.
		 */
		$order  = array( 'menu_order' => 'ASC' );

		// order by variables
		$order_val   = ( 'desc' == array_pop( $sort_params ) ) ? 'DESC' : 'ASC';

		// get sort value and meta key
		$sort_val = array_shift( $sort_params );
		$meta_key = 'wpcm_' . $sort_val;

		$sort_meta_entry = array(
			'key'     => $meta_key,
			'type'    => 'NUMERIC'
		);

		// set type to DATE for date
		if( $sort_val == 'frdate' ) {
			$sort_meta_entry['type'] = 'DATE';
		}

		// add date as a regular extra order entry
		if( $sort_val == 'date') {
			$order['date'] = $order_val;
		}else {
			// add an extra meta order entry
			$meta_query['orderby_meta'] = $sort_meta_entry;
			$order['orderby_meta'] = $order_val;

			// add a third sort parameter, date DESC. This way the newest listings with the given filter are shown on top.
			$order['date'] = 'DESC';
		}

		// \WP_Query arg
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => PostType::VEHICLE,
			'posts_per_page' => intval( $per_page ),
			'orderby'        => $order,
		);

		// check for make
		if ( is_array( $filters ) && count( $filters ) > 0 ) {
			foreach ( $filters as $filter_key => $filter_val ) {

				// var that will contain filter specific values
				$filter = array(
					'key'     => '',
					'value'   => '',
					'compare' => '=',
					'type'    => 'NUMERIC'
				);

				switch ( $filter_key ) {

					// check for make and model filter
					case 'make':
					case 'model':
						$filter['key']   = 'wpcm_' . $filter_key;
						$filter['value'] = absint( $filter_val );
						break;
					case 'price_from':
					case 'mileage_from':
					case 'frdate_from':
						$filter['key']     = 'wpcm_' . str_ireplace( '_from', '', $filter_key );
						$filter['compare'] = '>=';
						$filter['value']   = absint( $filter_val );
						break;
					case 'price_to':
					case 'mileage_to':
					case 'frdate_to':
						$filter['key']     = 'wpcm_' . str_ireplace( '_to', '', $filter_key );
						$filter['compare'] = '<=';
						$filter['value']   = absint( $filter_val );
						break;
					case 'condition':
						$filter['key']   = 'wpcm_condition';
						$filter['value'] = sanitize_title( $filter_val );
						$filter['type']  = 'CHAR';
						break;
					case 'hide_sold':
						if ( true === $filter_val ) {
							$filter['key']     = 'wpcm_sold';
							$filter['value']   = '1';
							$filter['compare'] = '!=';
							$filter['type']    = 'CHAR';
						}
						break;
					case 'featured':
						$filter_val = ($filter_val=='true');
						if ( true === $filter_val ) {
							$filter['key']     = 'wpcm_featured';
							$filter['value']   = '1';
							$filter['compare'] = '=';
							$filter['type']    = 'NUMERIC';
						} else if ( false === $filter_val ) {

							/*
							 * This is a more tricky one because we're adding 2 entries.
							 * The entries will be nested in their own group/array
							 * The group will have an OR relation (where global MQ has AND).
							 * We're adding it directly to $meta_query
							 */
							$meta_query[] = array(
								'relation' => 'OR',
								array(
									'key'     => 'wpcm_featured',
									'value'   => 0,
									'compare' => '=',
									'type'    => 'NUMERIC'
								),
								array(
									'key'     => 'wpcm_featured',
									'compare' => 'NOT EXISTS'
								)
							);

						}
						break;
					default:

						// allow filtering of non-catched filter key
						$filter = apply_filters( 'wpcm_get_vehicles_filter_' . $filter_key, $filter, $filter_key, $filter_val );

						break;
				}

				// check if we've got a new filter
				if ( ! empty( $filter['key'] ) ) {
					$meta_query[] = $filter;
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

		// get vehicles
		$db_vehicles = $this->vehicle_query->query( $args );

		// check
		if ( count( $db_vehicles ) > 0 ) {

			/** @var VehicleFactory $vehicle_factory */
			$vehicle_factory = wp_car_manager()->service( 'vehicle_factory' );

			// loop
			foreach ( $db_vehicles as $db_vehicle ) {

				// add vehicle to arry
				$vehicles[] = $vehicle_factory->make( $db_vehicle->ID );
			}
		}

		// reset post data
		wp_reset_postdata();

		return $vehicles;
	}

	/**
	 * Get total vehicle count of last get_vehicles() query
	 *
	 * @return int
	 */
	public function get_total_vehicle_count_of_last_query() {
		return intval( $this->vehicle_query->found_posts );
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

	// update the vehicle order
	public function update_vehicle_order( $vehicle_id ) {
		global $wpdb;

		// check if this vehicle is featured
		$featured = absint( get_post_meta( $vehicle_id, 'wpcm_featured', true ) );

		if( 1 === $featured ) {
			$wpdb->update( $wpdb->posts, array( 'menu_order' => -1 ), array( 'ID' => $vehicle_id ) );
		}else {
			$wpdb->update( $wpdb->posts, array( 'menu_order' => 0 ), array( 'ID' => $vehicle_id, 'menu_order' => -1 ) );
		}

		// be gone cache
		clean_post_cache( $vehicle_id );

	}


}