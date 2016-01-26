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
	 * Catch the publish action
	 */
	public function catch_publish_action() {
		if ( isset( $_GET['wpcm_publish'] ) ) {

			// vehicle ID that is requested to publish
			$vehicle_id = absint( $_GET['wpcm_publish'] );

			// redirect user to login screen if they can't edit this listing
			if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id ) ) {
				wp_redirect( wp_login_url( add_query_arg( 'wpcm_publish', $vehicle_id ) ) );
				exit;
			}

			// get vehicle
			/** @var Vehicle $vehicle */
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $vehicle_id );

			// set vehicle status
			$new_status = ( ( '1' == wp_car_manager()->service('settings')->get_option('moderate_new_listings') ) ? 'pending' : 'publish' );
			$new_status = apply_filters( 'wpcm_submit_publish_action_status', $new_status, $vehicle );
			$vehicle->set_status( $new_status );

			// @todo set vehicle expiration date

			// save vehicle
			$vehicle = wp_car_manager()->service( 'vehicle_repository' )->persist( $vehicle );

			// redirect to new url
			wp_redirect( apply_filters( 'wpcm_submit_publish_action_redirect', $vehicle->get_url(), $vehicle ) );

			// bye
			exit;
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
		if ( PostType::VEHICLE != $posts[0]->post_type ) {
			return $posts;
		}

		// only continue on preview posts
		if ( 'preview' != $posts[0]->post_status ) {
			return $posts;
		}

		// check if this user can edit this vehicle
		if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $posts[0]->ID ) ) {
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