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
		return apply_filters( 'wpcm_page_submit', wp_car_manager()->service( 'settings' )->get_option( 'page_submit' ) );
	}

	/**
	 * Get dashboard page URL
	 *
	 * @return string
	 */
	public static function get_page_dashboard() {
		return apply_filters( 'wpcm_page_dashboard', wp_car_manager()->service( 'settings' )->get_option( 'page_dashboard' ) );
	}

	/**
	 * Get listings page URL
	 *
	 * @return string
	 */
	public static function get_page_listings() {
		return apply_filters( 'wpcm_page_listings', wp_car_manager()->service( 'settings' )->get_option( 'page_listings' ) );
	}

}