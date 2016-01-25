<?php

namespace Never5\WPCarManager\Vehicle;

class PostStatus {

	/**
	 * Register Post Statuses
	 */
	public static function register() {

		// preview post status
		register_post_status( 'preview', array(
			'label'                     => _x( 'Preview', 'post status', 'wp-car-manager' ),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Preview <span class="count">(%s)</span>', 'Preview <span class="count">(%s)</span>', 'wp-car-manager' ),
		) );

		// expired post status
		register_post_status( 'expired', array(
			'label'                     => _x( 'Expired', 'post status', 'wp-car-manager' ),
			'public'                    => false,
			'protected'                 => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'wp-car-manager' ),
		) );


	}

}