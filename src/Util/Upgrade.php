<?php

namespace Never5\WPCarManager\Util;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

class Upgrade {

	const OPTION_CURRENT_VERSION = 'wpcm_current_version';

	/**
	 * Installation actions
	 */
	public function run() {

		// cet current version
		$current_version = get_option( self::OPTION_CURRENT_VERSION, 0 );

		// check if update is required
		if ( version_compare( wp_car_manager()->get_version(), $current_version, '>' ) ) {

			// do upgrade
			$this->do_upgrade( $current_version );

			// Update version code
			$this->update_current_version_code();
		}
	}

	/**
	 * Do the upgrade
	 *
	 * @param float $version
	 */
	private function do_upgrade( $version ) {

		// upgrade to 1.2.0
		if ( version_compare( $version, '1.2.0', '<' ) ) {
			// register pot type and custom taxonomies
			Vehicle\PostType::register();
			WPCarManager\Taxonomies::register_model_make();
			WPCarManager\Taxonomies::register_features();

			// setup user roles
			$role_manager = new WPCarManager\RoleManager();
			$role_manager->setup_roles();

			// setup cron
			$cron = new Vehicle\Cron();
			$cron->schedule();

			// flush rules
			flush_rewrite_rules();
		}

	}

	/**
	 * Set current plugin in database
	 */
	private function update_current_version_code() {
		update_option( self::OPTION_CURRENT_VERSION, wp_car_manager()->get_version() );
	}

}