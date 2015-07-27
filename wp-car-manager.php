<?php
/*
    Plugin Name: WP Car Manager
    Plugin URI: http://www.wpcarmanager.com
    Description: The easiest way to manage, list and sell your cars online using WordPress.
    Version: 1.0.0
    Author: Never5
    Author URI: http://www.never5.com
    License: GPL v2

	Copyright 2015 - Never5

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// autoloader
require 'vendor/autoload.php';

// check PHP version
$updatePhp = new WPUpdatePhp( '5.3.0' );
if ( $updatePhp->does_it_meet_required_php_version( PHP_VERSION ) ) {

	define( 'WP_CAR_MANAGER_FILE', __FILE__ );

	// create plugin object
	add_action( 'plugins_loaded', function () {

		// create instance
		$plugin = new Never5\WPCarManager\Plugin();

		// create & attach file object
		$plugin->attach( 'file', function () {
			return new Never5\WPCarManager\File( __FILE__ );
		} );

		error_log( $plugin->fetch('file')->plugin_path(), 0 );

		// I feel dirty
		$GLOBALS['wp-car-manager'] = $plugin;
	} );

}