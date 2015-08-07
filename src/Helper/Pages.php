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
			0 => __( 'Select Page', 'wp-car-manager' )
		);

		// get pages from WP
		$pages_raw = get_pages();

		// count. loop. add
		if(count($pages_raw)>0){
			foreach($pages_raw as $page) {
				$pages[$page->ID] = $page->post_title;
			}
		}

		// return
		return $pages;
	}

}