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
		$sort     = ( isset( $_GET['sort'] ) ) ? esc_attr( $_GET['sort'] ) : 'price-asc';
		$per_page = ( isset( $_GET['per_page'] ) ) ? intval( $_GET['per_page'] ) : - 1;

		// get vehicles
		$vehicle_manager = new Vehicle\Manager();
		$vehicles        = $vehicle_manager->get_vehicles( $filters, $sort, $per_page );

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
					'frdate'      => $vehicle->get_formatted_frdate()
				) );
			}
		} else {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/no-results', '', array() );
		}

		// bye
		exit;
	}

}