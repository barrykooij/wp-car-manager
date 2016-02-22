<?php

namespace Never5\WPCarManager\Util;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

class Install {

	/**
	 * Installation actions
	 */
	public static function run() {

		// register pot type and custom taxonomies
		Vehicle\PostType::register();
		WPCarManager\Taxonomies::register_model_make();
		WPCarManager\Taxonomies::register_features();

		// setup user roles
		$role_manager = new WPCarManager\RoleManager();
		$role_manager->setup_roles();

		// create cars listing page if not exists
		$listings_slug = sanitize_title( __( 'Cars', 'wp-car-manager' ) );
		$listings_page = get_page_by_path( $listings_slug );

		// check if listings page exists
		if ( null == $listings_page ) {

			// create page
			wp_insert_post( array(
				'post_type'    => 'page',
				'post_title'   => __( 'Cars', 'wp-car-manager' ),
				'post_content' => '[wpcm_cars]',
				'post_status'  => 'publish'
			) );
		}

		// setup cron
		$cron = new Vehicle\Cron();
		$cron->schedule();

		// flush rules after install
		flush_rewrite_rules();
	}
}