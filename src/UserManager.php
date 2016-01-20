<?php

namespace Never5\WPCarManager;

class UserManager {

	/**
	 * Return is it's allowed to create an account
	 *
	 * @return bool
	 */
	public function is_account_creation_allowed() {
		return ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_creation' ) );
	}

	/**
	 * Return if username is generated from email address
	 *
	 * @return bool
	 */
	public function is_generate_username_from_email() {
		return ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_username' ) );
	}

	/**
	 * Get the role that a newly created user will get
	 *
	 * @return string
	 */
	public function get_registration_role() {
		return apply_filters( 'wpcm_user_registration_role', wp_car_manager()->service( 'settings' )->get_option( 'account_role' ) );
	}

	/**
	 * Check if current user is allowed to post listing
	 *
	 * @return bool
	 */
	public function can_post_listing() {

		$can_post = true;

		// check if user is logged in
		if ( ! is_user_logged_in() ) {

			// can post depends on if user creation is allowed on post
			$can_post = $this->is_account_creation_allowed();
		}

		return apply_filters( 'wpcm_user_can_post_listing', $can_post );
	}

	/**
	 * Check if current user is allowed to edit given listing
	 *
	 * @param int $listing_id
	 *
	 * @return bool
	 */
	public function can_edit_listing( $listing_id ) {

		$can_edit = true;

		// deny access if user is not logged in or the listing id equals zero
		if ( ! is_user_logged_in() || 0 == $listing_id ) {
			$can_edit = false;
		} else {

			/** @var Vehicle\Vehicle $listing */
			$listing = wp_car_manager()->service( 'vehicle_factory' )->make( $listing_id );

			// check if listing author is equal to currently logged in user and if user has permission to edit listing
			if ( $listing->get_author() !== get_current_user_id() && ! current_user_can( 'edit_post', $listing->get_id() ) ) {
				$can_edit = false;
			}
		}

		return apply_filters( 'wpcm_user_can_edit_listing', $can_edit, $listing_id );
	}

	/**
	 * Create user account
	 *
	 * @param $args
	 *
	 * @return int newly created user ID
	 */
	public function create_account( $args ) {
		global $current_user;

		// defaults
		$defaults = array(
			'username' => '',
			'email'    => '',
			'password' => wp_generate_password(),
			'role'     => get_option( 'default_role' )
		);

		// merge args with defaults
		$data = wp_parse_args( $args, $defaults );

		// sanitize username
		$username = apply_filters( 'wpcm_user_registration_username', sanitize_user( $data['username'] ) );

		// sanitize email address
		$email = apply_filters( 'wpcm_user_registration_email', sanitize_email( $data['email'] ) );


		

		return $user_id;
	}

	/**
	 * Login user
	 *
	 * @param int $user_id
	 */
	public function login_user( $user_id ) {

	}

}