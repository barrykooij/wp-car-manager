<?php

namespace Never5\WPCarManager\Admin;

/**
 * Class CustomActions
 * @package Never5\WPCarManager\Admin
 *
 * Catch and handle custom actions
 */
class Menu {

	/**
	 *
	 */
	public function menu_pending_review_count_bubble() {
		global $submenu;

		$submenu_key = 'edit.php?post_type=wpcm_vehicle';

		if ( isset( $submenu[ $submenu_key ] ) ) {

			$pr_count = wp_car_manager()->service( 'vehicle_repository' )->num_rows( array(
				'fields'      => 'ids',
				'post_status' => 'pending'
			) );

			// Add count if user has access.
			if ( apply_filters( 'wpcm_admin_menu_show_pending_review_bubble', true ) && $pr_count > 0 ) {
				foreach ( $submenu[ $submenu_key ] as $key => $menu_item ) {
					if ( 0 === strpos( $menu_item[0], _x( 'All Car Listings', 'Admin menu name', 'wp-car-manager' ) ) ) {
						$submenu[ $submenu_key ][ $key ][0] .= ' <span class="awaiting-mod update-plugins count-' . esc_attr( $pr_count ) . '"><span class="processing-count">' . number_format_i18n( $pr_count ) . '</span></span>';
						break;
					}
				}
			}
		}
	}

}