<?php

namespace Never5\WPCarManager\Vehicle;

class PostStatus {

	/**
	 * Setup Post Status related stuff
	 */
	public function setup() {

		// register post statusses
		add_action( 'init', array( $this, 'register' ) );

		// set listing expiration on first publish
		add_action( 'transition_post_status', array( $this, 'set_expiration_on_first_publish' ), 10, 3 );

		// allow authors to preview their own posts
		$this->allow_preview();

		// add custom post statuses to WP post status list
		add_action( 'admin_footer-post.php', array( $this, 'append_to_post_status_list' ) );
	}


	/**
	 * Register Post Statuses
	 */
	public function register() {

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
	 * @param array $posts
	 *
	 * @return array
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

		// only continue on preview & pending posts
		if ( 'preview' != $posts[0]->post_status && 'pending' != $posts[0]->post_status ) {
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

	/**
	 * Catch first publish of car-lister created listings and set an expiration date
	 *
	 * @param string $new_status
	 * @param string $old_status
	 * @param \WP_Post $post
	 */
	public function set_expiration_on_first_publish( $new_status, $old_status, $post ) {

		// verify this is not an auto save routine.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// only catch posts of our vehicle post
		if ( PostType::VEHICLE != $post->post_type ) {
			return;
		}

		// new post status must be publish, old status can't be publish
		if ( 'publish' != $new_status || 'publish' == $old_status ) {
			return;
		}

		// check if listing is created by a 'car_seller'
		$user = get_user_by( 'id', $post->post_author );
		$role = array_shift( $user->roles );
		if ( 'car_seller' != $role ) {
			return;
		}

		// get the abs int value of the listing duration setting
		$exp_days = absint( wp_car_manager()->service( 'settings' )->get_option( 'listing_duration' ) );

		// check if custom exp_days is set for current listing
		$custom_exp_days = get_post_meta( $post->ID, '_wpcm_listing_duration', true );
		if ( ! empty( $custom_exp_days ) ) {
			$exp_days = absint( $custom_exp_days );
		}

		// only set an expiration date if the listing duration is at least 1 day
		if ( $exp_days < 1 ) {
			return;
		}

		// check if no expiration date is already set
		$cur_exp = get_post_meta( $post->ID, 'wpcm_expiration', true );
		if ( ! empty( $cur_exp ) ) {
			return;
		}

		// create \DateTime object and modify it to represent the date of expiration
		$exp_date = new \DateTime();
		$exp_date->setTime( 0, 0, 0 );
		$exp_date->modify( '+' . $exp_days . ' days' );

		// set expiration date
		update_post_meta( $post->ID, 'wpcm_expiration', $exp_date->format( 'Y-m-d' ) );
	}

	/**
	 * Add custom post statuses to WP post status list
	 */
	public function append_to_post_status_list() {
		global $post;

		// only for our post type
		if ( PostType::VEHICLE == $post->post_type ) {

			// empty
			$script = '';

			// our extra post statuses
			$post_status_arr = array(
				'expired' => __( 'Expired', 'wp-car-manager' ),
				'preview' => __( 'Preview', 'wp-car-manager' )
			);

			// make filterable
			$post_status_arr = apply_filters( 'wpcm_admin_post_status_list', $post_status_arr, $post );

			// count and loop
			if ( count( $post_status_arr ) > 0 ) {
				foreach ( $post_status_arr as $ps_key => $ps_val ) {

					// add script to $script
					$script .= "$('select#post_status').append(\"<option value='" . $ps_key . "'" . selected( $ps_key, $post->post_status, false ) . ">" . $ps_val . "</option>\");";

					if ( $post->post_status == $ps_key ) {
						$script .= "$('#post-status-display').html('" . $ps_val . "');";
					}

				}
			}

			// print script
			if ( ! empty( $script ) ) {
				echo "<script type='text/javascript'>jQuery(document).ready(function($){" . $script . "});</script>";
			}

		}
	}

}