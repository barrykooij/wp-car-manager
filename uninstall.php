<?php

// What is happening?
if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/**
 * @todo future version should contain a real proper clean procedure, for now we only clear the cronjob
 */

// autoload
require 'vendor/autoload.php';

// remove cron
$cron = new Never5\WPCarManager\Vehicle\Cron();
$cron->unschedule();