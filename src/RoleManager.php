<?php
namespace Never5\WPCarManager;

class RoleManager {

	/**
	 * Setup user roles
	 */
	public function setup_roles() {
		global $wp_roles;

		// setup \WP_Roles if not setup yet
		if ( class_exists( '\WP_Roles' ) && ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles();
		}

		// check prior setup
		if ( is_object( $wp_roles ) ) {

			// add WPCM role
			\add_role( 'car_seller', __( 'Car Seller', 'wp-car-manager' ), array(
				'read'         => true,
				'edit_posts'   => false,
				'delete_posts' => false
			) );

			// get wpcm core capabilities
			$capabilities = self::get_core_capabilities();

			// add wpcm core capabilities to administrator role
			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'administrator', $cap );
				}
			}

		}

	}

	/**
	 * Get WPCM core capabilities
	 *
	 * @return array
	 */
	private function get_core_capabilities() {
		return \apply_filters( 'wpcm_core_capabilities', array(
			'core'        => array(
				'manage_car_listings'
			),
			'car_listing' => array(
				'edit_car_listing',
				'read_car_listing',
				'delete_car_listing',
				'edit_car_listings',
				'edit_others_car_listings',
				'publish_car_listings',
				'read_private_car_listings',
				'delete_car_listings',
				'delete_private_car_listings',
				'delete_published_car_listings',
				'delete_others_car_listings',
				'edit_private_car_listings',
				'edit_published_car_listings',
				'manage_car_listing_terms',
				'edit_car_listing_terms',
				'delete_car_listing_terms',
				'assign_car_listing_terms'
			)
		) );
	}

}