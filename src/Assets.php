<?php
namespace Never5\WPCarManager;

abstract class Assets {

	/**
	 * Enqueue frontend assets
	 */
	public static function enqueue_frontend() {

		// frontend CSS
		wp_enqueue_style(
			'wpcm_css_frontend',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/css/frontend.css' ),
			array(),
			wp_car_manager()->get_version()
		);

		// load vehicle singular assets
		if ( is_singular( PostType::VEHICLE ) ) {
			// enqueue prettyPhoto lib
			wp_enqueue_script(
				'wpcm_js_pretty_photo',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/lib/jquery.prettyPhoto.min.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);
		}

		// load listings assets on listings page
		if ( get_the_ID() == wp_car_manager()->service( 'settings' )->get_option( 'listings_page' ) ) {
			// enqueue edit vehicle script
			wp_enqueue_script(
				'wpcm_js_listings',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/listings' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);

			wp_localize_script( 'wpcm_js_listings', 'wpcm', array(
				'ajax_url' => get_site_url(),
				'ajax_endpoint' => Ajax\Manager::ENDPOINT
			) );
		}


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
				array( 'jquery', 'jquery-ui-sortable' ),
				wp_car_manager()->get_version()
			);
		}

		if ( 'edit.php' == $pagenow && isset( $_GET['page'] ) && ( 'wpcm-settings' === $_GET['page'] || 'wpcm-extensions' === $_GET['page'] ) ) {

			// enqueue settings and extensions script
			wp_enqueue_script(
				'wpcm_settings',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/settings' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
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