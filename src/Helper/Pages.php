<?php

namespace Never5\WPCarManager\Helper;

class Pages {

	/**
	 * Get pages
	 *
	 * @return array
	 */
	public static function get_pages() {

		// setup array with default option
		$pages = array(
			0 => '-- ' . __( 'no page', 'wp-car-manager' ) . ' --'
		);

		// get pages from WP
		$pages_raw = get_pages();

		// count. loop. add
		if ( count( $pages_raw ) > 0 ) {
			foreach ( $pages_raw as $page ) {
				$pages[ $page->ID ] = $page->post_title;
			}
		}

		// return
		return $pages;
	}

	/**
	 * Get submit page URL
	 *
	 * @return string
	 */
	public static function get_page_submit() {
		$url     = '';
		$page_id = apply_filters( 'wpcm_page_id_submit', wp_car_manager()->service( 'settings' )->get_option( 'page_submit' ) );
		if ( 0 != $page_id ) {
			$url = get_permalink( $page_id );
		}

		return apply_filters( 'wpcm_page_url_submit', $url );
	}

	/**
	 * Get dashboard page URL
	 *
	 * @param int Vehicle ID
	 *
	 * @return string
	 */
	public static function get_page_edit( $vehicle_id ) {

		// get submit url
		$url = self::get_page_submit();

		// add the wpcm_edit query var
		$url = add_query_arg( 'wpcm_edit', 1, $url );

		// add wpcm_vehicle_id query var
		$url = add_query_arg( 'wpcm_vehicle_id', $vehicle_id, $url );

		// return the filterable URL
		return apply_filters( 'wpcm_page_url_edit', $url, $vehicle_id );
	}

	/**
	 * Get Dashboard page ID
	 *
	 * @return int
	 */
	public static function get_page_dashboard_id() {
		return apply_filters( 'wpcm_page_id_dashboard', wp_car_manager()->service( 'settings' )->get_option( 'page_dashboard' ) );
	}

	/**
	 * Get dashboard page URL
	 *
	 * @return string
	 */
	public static function get_page_dashboard() {
		$url     = '';
		$page_id = self::get_page_dashboard_id();
		if ( 0 != $page_id ) {
			$url = get_permalink( $page_id );
		}

		return apply_filters( 'wpcm_page_url_dashboard', $url );
	}

	/**
	 * Get listings page URL
	 *
	 * @return string
	 */
	public static function get_page_listings() {
		$url     = '';
		$page_id = apply_filters( 'wpcm_page_id_listings', wp_car_manager()->service( 'settings' )->get_option( 'page_listings' ) );
		if ( 0 != $page_id ) {
			$url = get_permalink( $page_id );
		}

		return apply_filters( 'wpcm_page_url_listings', $url );
	}

}