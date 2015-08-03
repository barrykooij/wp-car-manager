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
		global $pagenow, $post;

		// Enqueue Downloadable Files Metabox JS
		if ( ( $pagenow == 'post.php' && isset( $post ) && PostType::VEHICLE === $post->post_type ) || ( $pagenow == 'post-new.php' && isset( $_GET['post_type'] ) && PostType::VEHICLE == $_GET['post_type'] ) ) {

			// enqueue edit vehicle script
			wp_enqueue_script(
				'wpcm_edit_download',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/edit-vehicle' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);
		}

		// admin CSS
		wp_enqueue_style(
			'wpcm_admin',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/css/admin.css' ),
			array(),
			wp_car_manager()->get_version()
		);

	}

}