<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class DismissNotice extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'dismiss_notice' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// check nonce
		$this->check_nonce();

		// id must be set
		if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// sanitize variables
		$notice_id = sanitize_title( $_GET['id'] );

		// all dismissable notices
		$notices = array(
			'onboarding'
		);

		// just making sure people can't post all kind of string that will be saved in the database
		if ( ! in_array( $notice_id, $notices ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// set notice option
		update_option( 'wpcm_notice_'.$notice_id, 1 );

		// done
		wp_send_json( array( 'success' => true ) );

		// bye
		exit;
	}

}