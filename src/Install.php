<?php

namespace Never5\WPCarManager;

class Install {

	/**
	 * Installation actions
	 */
	public static function install() {

		// register pot type and custom taxonomies
		Vehicle\PostType::register();
		Taxonomies::register_model_make();
		Taxonomies::register_features();

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

		// flush rules after install
		flush_rewrite_rules();
	}
}
