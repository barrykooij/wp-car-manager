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

	/**
	 * Allow vehicle author to preview their own listings
	 */
	public function allow_preview() {
		// only add filter for logged in users
		if ( is_user_logged_in() ) {
			add_action( 'pre_get_posts', array( $this, 'catch_preview_pre_post' ), 10, 1 );
		}
	}

	/**
	 *
	 * Catch the pre post
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function catch_preview_pre_post( $query ) {
		if ( $query->is_main_query() && $query->is_singular() ) {
			add_filter( 'posts_results', array( $this, 'morph_preview_to_publish' ), 10, 2 );
		}

		return $query;
	}

	/**
	 * Morph preview state to publish state
	 *
	 * @param $posts
	 */
	public function morph_preview_to_publish( $posts ) {

		// remove filter so we don't slow down / alter other queries
		remove_filter( 'posts_results', array( $this, 'morph_preview_to_publish' ), 10, 2 );

		// return empty array if array is empty
		if ( empty( $posts ) ) {
			return $posts;
		}

		// check if user is logged in
		if ( ! is_user_logged_in() ) {
			return $posts;
		}

		// check if we're dealing with a wpcm_vehicle post type
		if( PostType::VEHICLE != $posts[0]->post_type) {
			return $posts;
		}

		// only continue on preview posts
		if( 'preview' != $posts[0]->post_status ) {
			return $posts;
		}

		// check if this user can edit this vehicle
		if( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $posts[0]->ID ) ) {
			return $posts;
		}

		// All good, set post status to publish so that it's visible
		$posts[0]->post_status = 'publish';

		// Disable comments and pings for this post
		add_filter( 'comments_open', '__return_false' );
		add_filter( 'pings_open', '__return_false' );

		return $posts;
	}

}