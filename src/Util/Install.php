<?php

namespace Never5\WPCarManager\Util;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

class Install {

	/**
	 * Installation actions
	 */
	public static function run() {

		// register post type and custom taxonomies
		Vehicle\PostType::register();
		WPCarManager\Taxonomies::register_model_make();
		WPCarManager\Taxonomies::register_features();

		// setup user roles
		$role_manager = new WPCarManager\RoleManager();
		$role_manager->setup_roles();

		// setup cron
		$cron = new Vehicle\Cron();
		$cron->schedule();

		// flush rules after install
		flush_rewrite_rules();

		// set version
		update_option( Upgrade::OPTION_CURRENT_VERSION, wp_car_manager()->get_version() );
	}
}