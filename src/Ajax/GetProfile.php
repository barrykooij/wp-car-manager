<?php

namespace Never5\WPCarManager\Ajax;

class GetProfile extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'get_profile' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// return fields
		$return = array( 'success' => false, 'errors' => array(), 'data' => array() );

		try {

			// check nonce
			$this->check_nonce();

			// not allowed by default
			$is_allowed = false;

			// get current user id
			if ( is_user_logged_in() ) {

				// get logged in user
				$user = wp_get_current_user();

				// make sure we've got a logged in user
				if ( false != $user ) {
					$is_allowed = true;
				}
			}

			// requester not allowed to do what they try to do
			if ( true != $is_allowed ) {
				throw new SaveProfileException( __( 'Not allowed to get profile data.', 'wp-car-manager' ), 'not-allowed' );
			}

			// data
			$return['success'] = true;
			$return['data']    = array(
				'email' => esc_html( get_user_meta( $user->ID, 'wpcm_email', true ) ),
				'phone' => esc_html( get_user_meta( $user->ID, 'wpcm_phone', true ) )
			);


		} catch ( SaveProfileException $e ) {
			$return['success'] = false;
			$return['errors']  = array(
				'id'  => $e->getId(),
				'msg' => $e->getMessage()
			);
		}

		// send JSON
		wp_send_json( $return );

		// bye
		exit;
	}

}