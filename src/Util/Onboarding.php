<?php

namespace Never5\WPCarManager\Util;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager\Ajax;
use Never5\WPCarManager;

class Onboarding {

	/**
	 * Setup onboarding
	 */
	public function setup() {

		// add page
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );

		// add notice
		if ( false === get_option( 'wpcm_notice_onboarding' ) && ( ! isset( $_GET['page'] ) || ( isset( $_GET['page'] ) && 'wpcm_onboarding' != $_GET['page'] ) ) ) {
			add_action( 'admin_notices', array( $this, 'add_notice' ) );

			// notice JS -.-
			add_action( 'in_admin_footer', function () {
				?>
				<script type="text/javascript">
					jQuery( function ( $ ) {
						$( '.wpcm-notice' ).on( 'click', '.notice-dismiss', function ( event ) {
							$.get( '<?php echo Ajax\Manager::get_ajax_url( 'dismiss_notice' ); ?>', {
								id: $( this ).closest( '.wpcm-notice' ).data( 'id' ),
								nonce: '<?php echo wp_create_nonce( 'wpcm_ajax_nonce_dismiss_notice' ) ?>'
							}, function () {
							} );
						} );
					} );
				</script>
				<?php
			} );
		}

	}

	/**
	 * Add admin page
	 */
	public function add_admin_page() {
		// add page
		$menu_hook = \add_submenu_page( null, 'WPCM_ONBOARDING', 'WPCM_ONBOARDING', 'edit_posts', 'wpcm_onboarding', array(
			$this,
			'page'
		) );

		// load onboarding assets
		add_action( 'load-' . $menu_hook, array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue onboarding assets
	 */
	public function enqueue_assets() {
		wp_enqueue_script(
			'wpcm_onboarding',
			wp_car_manager()->service( 'file' )->plugin_url( '/assets/js/onboarding' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js' ),
			array( 'jquery' ),
			wp_car_manager()->get_version()
		);

		wp_localize_script( 'wpcm_onboarding', 'wpcm', array(
			'ajax_url_create_page' => Ajax\Manager::get_ajax_url( 'create_page' ),
			'nonce_create_page'    => wp_create_nonce( 'wpcm_ajax_nonce_create_page' ),
			'lbl_creating'         => __( 'Creating', 'wp-car-manager' ) . '...',
			'lbl_created'          => __( 'Page created', 'wp-car-manager' ),
			'lbl_create_page'      => __( 'Create Page', 'wp-car-manager' ),
		) );
	}

	/**
	 * Onboarding notice
	 */
	public function add_notice() {
		?>
		<div class="notice notice-warning is-dismissible wpcm-notice" data-id="onboarding">
			<p><?php printf( __( 'WP Car Manager is almost ready for use, %sclick here%s to setup the final settings.', 'wp-car-manager' ), '<a href="' . admin_url( 'edit.php?post_type=' . Vehicle\PostType::VEHICLE . '&page=wpcm_onboarding' ) . '">', '</a>' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Onboarding page
	 */
	public function page() {

		// been there, done that
		update_option( 'wpcm_notice_onboarding', 1 );

		// the actual page
		?>
		<div class="wrap wpcm-onboarding">
			<h2>WP Car Manager - <?php _e( 'Setup', 'wp-car-manager' ); ?></h2>
			<p><?php _e( "Thank you for using WP Car Manager! We'd like to help you setup the plugin correctly so you can start listing your cars as quickly as possible.", 'wp-car-manager' ); ?></p>

			<fieldset id="wpcm-pages">
				<h3><?php _e( 'Pages', 'wp-car-manager' ); ?></h3>
				<p><?php _e( 'WP Car Manager needs 3 pages setup with specific shortcodes to function correct. We can create and setup these pages for you at this moment or you can create them yourself and set them in the settings screen.', 'wp-car-manager' ); ?></p>
				<table cellpadding="0" cellspacing="0" border="0" class="wpcm-onboarding-pages">
					<tr>
						<th><?php _e( 'Page', 'wp-car-manager' ); ?></th>
						<th><?php _e( 'Description', 'wp-car-manager' ); ?></th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<td>
							<a href="https://www.wpcarmanager.com/kb/listings-page/?utm_source=plugin&utm_medium=link&utm_campaign=onboarding"
							   target="_blank"><?php _e( 'Car Listings', 'wp-car-manager' ); ?></a></td>
						<td><?php _e( 'The page containing your car listings', 'wp-car-manager' ); ?></td>
						<td><a href="javascript:;"
						       class="button button-primary"
						       data-page="listings"><?php _e( 'Create Page', 'wp-car-manager' ); ?></a></td>
					</tr>
					<tr>
						<td>
							<a href="https://www.wpcarmanager.com/kb/submit-car-form/?utm_source=plugin&utm_medium=link&utm_campaign=onboarding"
							   target="_blank"><?php _e( 'Submit Car Page', 'wp-car-manager' ); ?></a></td>
						<td><?php _e( 'Users can submit their own listings via this page', 'wp-car-manager' ); ?></td>
						<td><a href="javascript:;"
						       class="button button-primary"
						       data-page="submit"><?php _e( 'Create Page', 'wp-car-manager' ); ?></a></td>
					</tr>
					<tr>
						<td>
							<a href="https://www.wpcarmanager.com/kb/car-dashboard/?utm_source=plugin&utm_medium=link&utm_campaign=onboarding"
							   target="_blank"><?php _e( 'Car Dashboard', 'wp-car-manager' ); ?></a></td>
						<td><?php _e( 'An overview page of all cars created of logged in user', 'wp-car-manager' ); ?></td>
						<td><a href="javascript:;"
						       class="button button-primary"
						       data-page="dashboard"><?php _e( 'Create Page', 'wp-car-manager' ); ?></a></td>
					</tr>

				</table>
			</fieldset>

			<fieldset id="wpcm-never5">
				<h3><?php _e( 'A Never5 Product', 'wp-car-manager' ); ?></h3>
				<a href="http://www.never5.com" target="_blank"><img
						src="<?php echo wp_car_manager()->service( 'file' )->plugin_url( '/assets/images/never5-logo.png' ); ?>"
						alt="Never5" style="float:left;padding:0 10px 10px 0;"/></a>

				<p><?php printf( __( 'At %sNever5%s we create high quality premium WordPress plugins, with extensive support. We offer solutions in related posts, advanced download management, vehicle management and connecting post types.', 'wp-car-manager' ), '<a href="http://www.never5.com" target="_blank">', '</a>' ); ?></p>

				<p><?php printf( __( "%sFollow Never5 on Twitter%s", 'wp-car-manager' ), '<a href="https://twitter.com/Never5Plugins" target="_blank">', '</a>' ); ?></p>

			</fieldset>

			<fieldset id="wpcm-extensions">
				<h3><?php _e( 'Extensions', 'wp-car-manager' ); ?></h3>
				<p><?php _e( 'Power up your WP Car Manager website with our official extensions. Our extensions allow you to add very specific functionality to your WP Car Manager installation and come with our premium support and updates.', 'wp-car-manager' ); ?></p>
				<p>
					<a href="https://www.wpcarmanager.com/extensions/?utm_source=plugin&utm_medium=link&utm_campaign=onboarding"
					   target="_blank"><?php _e( 'Read more about our extensions', 'wp-car-manager' ); ?> >></a></p>
			</fieldset>

			<fieldset id="wpcm-whats-next">
				<h3><?php _e( "What's next?", 'wp-car-manager' ); ?></h3>

				<p><?php printf( __( "Now that you have created the required pages, it's time to setup your Makes & Models. You can %sread more about Makes & Models here%s or %screate them here%s.", 'wp-car-manager' ), '<a href="https://www.wpcarmanager.com/kb/makes-models/?utm_source=plugin&utm_medium=link&utm_campaign=onboarding" target="_blank">', '</a>', '<a href="' . admin_url( 'edit.php?post_type=' . Vehicle\PostType::VEHICLE . '&page=wpcm-makes' ) . '">', '</a>' ); ?></p>


			</fieldset>
		</div>
		<?php
	}
}