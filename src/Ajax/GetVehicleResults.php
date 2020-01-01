<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager\Helper;

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

		// set filters
		$filters = array();

		// get filters from get vars
		foreach ( $_GET as $get_key => $get_var ) {
			if ( 0 === strpos( $get_key, 'filter_' ) ) {
				$filters[ str_ireplace( 'filter_', '', $get_key ) ] = $get_var;
			}
		}

		// set sort
		$sort = ( isset( $_GET['sort'] ) ) ? esc_attr( $_GET['sort'] ) : 'price-asc';

		// set per page
		if (isset( $_GET['per_page'] ) ) {
			$per_page = intval( esc_attr( $_GET['per_page'] ) );
		} else {
			$per_page = intval( wp_car_manager()->service( 'settings' )->get_option( 'listings_ppp' ) );
		}
		
		// correct any funky zero listings per page. I mean, who wants 0 listings per page ...
		if ( 0 === $per_page ) {
			$per_page = - 1;
		}

		// get current page
		$page = intval( ( ( ! empty( $_GET['page'] ) ) ? $_GET['page'] : 1 ) );

		// check if we need to hide sold cars
		if ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'listings_hide_sold' ) ) {
			$filters['hide_sold'] = true;
		} else {
			$filters['hide_sold'] = false;
		}

		// extra args
		$extra_args = array();

		if ( $page > 0 ) {
			$extra_args['paged'] = $page;
		}

		// get vehicles
		$vehicle_manager = new Vehicle\Manager();
		$vehicles        = $vehicle_manager->get_vehicles( $filters, $sort, $per_page, $extra_args );

		// get total vehicle count for pagination
		$total_vehicle_count = $vehicle_manager->get_total_vehicle_count_of_last_query();

		// start output buffer
		ob_start();

		// check & loop
		if ( count( $vehicles ) > 0 ) {

			foreach ( $vehicles as $vehicle ) {

				// title
				$title = get_the_title( $vehicle->get_id() );

				// check if there's a thumbnail
				if ( has_post_thumbnail( $vehicle->get_id() ) ) {

					// get image
					$image = get_the_post_thumbnail( $vehicle->get_id(), apply_filters( 'wpcm_listings_vehicle_thumbnail_size', 'wpcm_vehicle_listings_item' ), array(
						'title' => $title,
						'alt'   => $title,
						'class' => 'wpcm-listings-item-image'
					) );

				} else {
					$placeholder = apply_filters( 'wpcm_listings_vehicle_thumbnail_placeholder', wp_car_manager()->service( 'file' )->image_url( 'placeholder-list.png' ), $vehicle );
					$image       = sprintf( '<img src="%s" alt="%s" class="wpcm-listings-item-image" />', $placeholder, __( 'Placeholder', 'wp-car-manager' ) );
				}


				// load template
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/item', '', array(
					'url'         => $vehicle->get_url(),
					'title'       => $title,
					'image'       => $image,
					'description' => $vehicle->get_short_description(),
					'price'       => $vehicle->get_formatted_price(),
					'mileage'     => $vehicle->get_formatted_mileage(),
					'frdate'      => $vehicle->get_formatted_frdate(),
					'vehicle'     => $vehicle
				) );
			}

		} else {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/no-results', '', array() );
		}

		// put listing content in variable
		$listing_content = ob_get_clean();

		// send JSON response
		wp_send_json( array(
			'listings'   => $listing_content,
			'pagination' => \Never5\WPCarManager\Helper\Pagination::generate( $page, \Never5\WPCarManager\Helper\Pagination::calc_total_pages( $per_page, $total_vehicle_count ) )
		) );

		// bye
		exit;
	}

}