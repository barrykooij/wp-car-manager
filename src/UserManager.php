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
			if ( $listing->get_author() != get_current_user_id() && ! current_user_can( 'edit_car_listing', $listing->get_id() ) ) {
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
		$data['username'] = apply_filters( 'wpcm_user_registration_username', sanitize_user( $data['username'] ) );

		// sanitize email address
		$data['email'] = apply_filters( 'wpcm_user_registration_email', sanitize_email( $data['email'] ) );

		// Email address can't be empty
		if ( empty( $data['email'] ) ) {
			return new WP_Error( 'validation-error', __( 'Invalid email address.', 'wp-car-manager' ) );
		}

		// check if
		if ( empty( $data['username'] ) ) {
			$data['username'] = sanitize_user( current( explode( '@', $data['email'] ) ) );
		}

		// validate email address
		if ( ! is_email( $data['email'] ) ) {
			return new WP_Error( 'validation-error', __( "Your email address isn't correct.", 'wp-car-manager' ) );
		}

		// check if email address exists
		if ( email_exists( $data['email'] ) ) {
			return new \WP_Error( 'validation-error', __( 'This email is already registered, please choose another one.', 'wp-car-manager' ) );
		}

		// ensure username is unique
		$append     = 1;
		$o_username = $data['username'];
		while ( username_exists( $data['username'] ) ) {
			$data['username'] = $o_username . $append;
			$append ++;
		}

		// mimicking WP core user registration error checking (registration_errors filter)
		$reg_errors = new \WP_Error();
		$reg_errors = apply_filters( 'wpcm_registration_errors', $reg_errors, $data['username'], $data['email'] );

		// mimicking WP Core register_post action
		do_action( 'wpcm_register_post', $data['username'], $data['email'], $reg_errors );

		// check if we're still error free
		if ( $reg_errors->get_error_code() ) {
			return $reg_errors;
		}

		// new user arguments
		$new_user_args = apply_filters( 'wpcm_create_account_data', array(
			'user_login' => $data['username'],
			'user_pass'  => $data['password'],
			'user_email' => $data['email'],
			'role'       => $data['role']
		) );

		// create the account
		$user_id = wp_insert_user( $new_user_args );

		// check if user was created successfully
		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}

		// send new user email
		$this->send_new_account_email( $user_id, $data['password'] );

		// return new account ID
		return $user_id;
	}

	/**
	 * Send new account email
	 *
	 * @param int $user_id
	 * @param string $password
	 *
	 * @return bool
	 */
	private function send_new_account_email( $user_id, $password ) {
		global $wp_version;

		// wp_new_user_notification changed in 4.3.1, see https://codex.wordpress.org/Function_Reference/wp_new_user_notification
		if ( version_compare( $wp_version, '4.3.1', '<' ) ) {
			wp_new_user_notification( $user_id, $password );
		} else {
			wp_new_user_notification( $user_id, null, 'both' );
		}

		return true;
	}

	/**
	 * Login user
	 *
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function login_user( $user_id ) {
		global $current_user;

		wp_set_auth_cookie( $user_id, true, is_ssl() );
		$current_user = get_user_by( 'id', $user_id );

		return true;
	}

}