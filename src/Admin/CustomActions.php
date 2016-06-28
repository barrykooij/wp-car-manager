<?php

namespace Never5\WPCarManager\Admin;

/**
 * Class CustomActions
 * @package Never5\WPCarManager\Admin
 *
 * Catch and handle custom actions
 */
class CustomActions {

	/**
	 * Listen
	 */
	public function listen() {
		add_action( 'admin_init', array( $this, 'handle' ) );
	}

	/**
	 * Handle wpcm_custom_action
	 */
	public function handle() {
		if ( isset( $_GET['wpcm_action'] ) && isset( $_GET['wpcm_action_val'] ) ) {

			// check nonce
			if ( false == wp_verify_nonce( $_GET['wpcm_nonce'], 'wpcm_action_' . $_GET['wpcm_action'] . '_' . $_GET['wpcm_action_val'] ) ) {
				wp_die( 'Nonce invalid' );
			}

			// vehicle ID
			$vid = absint( $_GET['wpcm_action_val'] );

			// Let's go
			wp_update_post( array( 'ID' => $vid, 'post_status' => 'publish' ) );
		}
	}

}