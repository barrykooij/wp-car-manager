<?php
namespace Never5\WPCarManager;

abstract class Assets {

	private static $shortcode_assets_enqueued = array();

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
		if ( is_singular( Vehicle\PostType::VEHICLE ) ) {

			// enqueue prettyPhoto lib
			wp_enqueue_script(
				'wpcm_js_pretty_photo',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/lib/jquery.prettyPhoto.min.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);

			// do action wpcm_assets_frontend_vehicle_single
			do_action( 'wpcm_assets_frontend_vehicle_single' );
		}

	}

	/**
	 * Enqueue shortcode related Js
	 */
	public static function enqueue_shortcode_cars() {

		if ( in_array( 'cars', self::$shortcode_assets_enqueued ) ) {
			return;
		}

		self::$shortcode_assets_enqueued[] = 'cars';

		// enqueue select2 script
		wp_enqueue_script(
			'wpcm_js_select2',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/lib/select2.min.js' ),
			array( 'jquery' ),
			wp_car_manager()->get_version(),
			true
		);

		// enqueue listings script
		wp_enqueue_script(
			'wpcm_js_listings',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/listings' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
			array( 'jquery', 'wpcm_js_select2' ),
			wp_car_manager()->get_version(),
			true
		);

		wp_localize_script( 'wpcm_js_listings', 'wpcm', array(
			'ajax_url'              => trailingslashit( get_site_url( '' ) ),
			'ajax_endpoint'         => Ajax\Manager::ENDPOINT,
			'nonce_models'          => wp_create_nonce( 'wpcm_ajax_nonce_get_models' ),
			'lbl_no_models_found'   => __( 'No models found', 'wp-car-manager' ),
			'lbl_select_make_first' => __( 'Select make first', 'wp-car-manager' )
		) );

		// do action wpcm_assets_frontend_vehicle_single
		do_action( 'wpcm_assets_frontend_vehicle_listings_page' );

	}

	/**
	 * Enqueue backend(admin) assets
	 */
	public static function enqueue_backend() {
		global $pagenow, $post;

		// Enqueue Downloadable Files Metabox JS
		if ( ( $pagenow == 'post.php' && isset( $post ) && Vehicle\PostType::VEHICLE === $post->post_type ) || ( $pagenow == 'post-new.php' && isset( $_GET['post_type'] ) && Vehicle\PostType::VEHICLE == $_GET['post_type'] ) ) {

			// datepicker
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

			// enqueue edit vehicle script
			wp_enqueue_script(
				'wpcm_edit_download',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/edit-vehicle' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
				array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-datepicker' ),
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

		// extensions Js
		if ( isset( $_GET['page'] ) && 'wpcm-extensions' === $_GET['page'] ) {
			wp_enqueue_script(
				'wpcm_extensions',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/extensions' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);
		}

		// edit makes and models
		if ( isset( $_GET['page'] ) && 'wpcm-makes' === $_GET['page'] ) {
			wp_enqueue_script(
				'wpcm_tipped',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/lib/tipped.js' ),
				array( 'jquery' ),
				wp_car_manager()->get_version()
			);

			wp_enqueue_script(
				'wpcm_edit_make_model',
				wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/edit-make-model' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
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