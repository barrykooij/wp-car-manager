<?php
namespace Never5\WPCarManager\Helper;

/**
 * Class Roles
 * @package Never5\WPCarManager\Helper
 *
 */
abstract class Roles {

	/**
	 * Get available WordPress user account roles
	 *
	 * @return array
	 */
	public static function get_roles() {

		$roles = array();

		// get WP roles
		$wp_roles = \get_editable_roles();

		if ( count( $wp_roles ) > 0 ) {
			foreach ( $wp_roles as $key => $role ) {
				$roles[ $key ] = $role['name'];
			}
		}

		return $roles;
	}

}