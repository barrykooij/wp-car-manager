<?php
namespace Never5\WPCarManager\Helper;

/**
 * Class Date
 * @package Never5\WPCarManager\Helper
 *
 */
abstract class Date {

	/**
	 * Get date format
	 *
	 * @return String
	 */
	public static function get_date_format() {
		return apply_filters( 'wpcm_date_format', 'm-Y' );
	}


}