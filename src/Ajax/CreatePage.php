<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class CreatePage extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'create_page' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// check nonce
		$this->check_nonce();

		// check if make is set
		if ( ! isset( $_POST['page'] ) ) {
			return;
		}

		// check if user is allowed to create page
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		// sanitize
		$page = sanitize_title( $_POST['page'] );

		$success = false;

		$page_data = array();

		switch ( $page ) {
			case 'submit':
				$page_data = array(
					'title'   => \__( 'Submit Car', 'wp-car-manager' ),
					'content' => '[wpcm_submit_car_form]'
				);
				break;
			case 'dashboard':
				$page_data = array( 'title' => \__( 'My Cars', 'wp-car-manager' ), 'content' => '[wpcm_dashboard]' );
				break;
			case 'listings':
				$page_data = array( 'title' => \__( 'Cars', 'wp-car-manager' ), 'content' => '[wpcm_cars]' );
				break;
		}

		if ( ! empty( $page_data ) ) {

			// create page
			$page_id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_author'  => get_current_user_id(),
				'post_title'   => $page_data['title'],
				'post_content' => $page_data['content']
			) );

			// setting
			if ( 0 != $page_id ) {
				update_option( 'wpcm_page_' . $page, $page_id );
				$success = true;
			}
		}


		// send JSON
		wp_send_json( array( 'success' => $success ) );

		// bye
		exit;
	}

}