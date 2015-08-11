<?php

namespace Never5\WPCarManager;

class Install {

	/**
	 * Installation actions
	 */
	public static function install() {
		// Register pot type and custom taxonomies
		PostType::register();
		Taxonomies::register_model_make();
		Taxonomies::register_features();

		// Flush rules after install
		flush_rewrite_rules();
	}
}
