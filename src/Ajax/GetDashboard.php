<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager\Helper;

class GetDashboard extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'get_dashboard' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// check nonce
		$this->check_nonce();

		// set per page
		$per_page = intval( wp_car_manager()->service( 'settings' )->get_option( 'listings_ppp' ) );

		// correct any funky zero listings per page. I mean, who wants 0 listings per page ...
		if ( 0 === $per_page ) {
			$per_page = - 1;
		}

		// get current page
		$page = intval( ( ( ! empty( $_GET['page'] ) ) ? $_GET['page'] : 1 ) );

		// set sort
		$sort = ( isset( $_GET['sort'] ) ) ? esc_attr( $_GET['sort'] ) : 'price-desc';

		// extra args
		$extra_args = array(
			'author'      => get_current_user_id(),
			'post_status' => apply_filters( 'wpcm_dashboard_post_status', array( 'publish', 'expired', 'pending' ) )
		);

		if ( $page > 0 ) {
			$extra_args['paged'] = $page;
		}

		// get vehicles
		$vehicle_manager = new Vehicle\Manager();
		$vehicles        = $vehicle_manager->get_vehicles( array(), $sort, $per_page, apply_filters( 'wpcm_dashboard_get_vehicles_extra_args', $extra_args ) );

		// get total vehicle count for pagination
		$total_vehicle_count = $vehicle_manager->get_total_vehicle_count_of_last_query();

		// start output buffer
		ob_start();

		// check & loop
		if ( count( $vehicles ) > 0 ) {

			// Today
			$today = new \DateTime();
			$today->setTime( 0, 0, 0 );

			foreach ( $vehicles as $vehicle ) {

				// title
				$title = get_the_title( $vehicle->get_id() );

				// check if there's a thumbnail
				if ( has_post_thumbnail( $vehicle->get_id() ) ) {

					// get image
					$image = get_the_post_thumbnail( $vehicle->get_id(), apply_filters( 'wpcm_dashboard_vehicle_thumbnail_size', 'wpcm_vehicle_listings_item' ), array(
						'title' => $title,
						'alt'   => $title,
						'class' => 'wpcm-dashboard-item-image'
					) );

				} else {
					$placeholder = apply_filters( 'wpcm_dashboard_vehicle_thumbnail_placeholder', wp_car_manager()->service( 'file' )->image_url( 'placeholder-list.png' ), $vehicle );
					$image       = sprintf( '<img src="%s" alt="%s" class="wpcm-dashboard-item-image" />', $placeholder, __( 'Placeholder', 'wp-car-manager' ) );
				}

				$expires = 'n/a';
				if ( null != $vehicle->get_expiration() ) {
					if ( $today > $vehicle->get_expiration() ) {
						$expires = __( 'Expired', 'wp-car-manager' );
					} else {

						$expires = $vehicle->get_expiration()->format( 'd-m-Y' );
					}
				}


				// load template
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/item', '', array(
					'id'      => $vehicle->get_id(),
					'url'     => $vehicle->get_url(),
					'title'   => $title,
					'image'   => $image,
					'price'   => $vehicle->get_formatted_price(),
					'mileage' => $vehicle->get_formatted_mileage(),
					'frdate'  => $vehicle->get_formatted_frdate(),
					'expires' => $expires,
					'vehicle' => $vehicle
				) );
			}
		} else {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/no-results', '', array() );
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