<?php
namespace Never5\WPCarManager\Helper;

abstract class Price {

	/**
	 * Get price format
	 *
	 * @return String
	 */
	public static function get_price_format() {
		$currency_pos = wp_car_manager()->service( 'settings' )->get_option( 'currency_pos' );
		$format       = '%1$s%2$s';

		switch ( $currency_pos ) {
			case 'left' :
				$format = '%1$s%2$s';
				break;
			case 'right' :
				$format = '%2$s%1$s';
				break;
			case 'left_space' :
				$format = '%1$s&nbsp;%2$s';
				break;
			case 'right_space' :
				$format = '%2$s&nbsp;%1$s';
				break;
		}

		return $format;
	}

}