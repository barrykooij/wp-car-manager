<?php
namespace Never5\WPCarManager;

abstract class Assets {

	/**
	 * Enqueue frontend assets
	 */
	public static function enqueue_frontend() {
		// frontend CSS
		wp_enqueue_style(
			'wpcm_frontend',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/css/frontend.css' ),
			array(),
			wp_car_manager()->get_version()
		);
	}

	/**
	 * Enqueue backend(admin) assets
	 */
	public static function enqueue_backend() {

		// admin CSS
		wp_enqueue_style(
			'wpcm_admin',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/css/admin.css' ),
			array(),
			wp_car_manager()->get_version()
		);

	}

}