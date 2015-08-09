<?php

namespace Never5\WPCarManager\Admin\Page;

class Settings {

	/**
	 * Init page
	 */
	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Settings', 'wp-car-manager' ), __( 'Settings', 'wp-car-manager' ), 'manage_options', 'wpcm-settings', array(
			$this,
			'page_cb'
		) );
	}

	/**
	 * Output page
	 */
	public function page_cb() {

		// load view
		wp_car_manager()->service( 'view_manager' )->display( 'page/settings', array(
			'fields' => wp_car_manager()->service('settings')->get_fields()
		) );
	}

}