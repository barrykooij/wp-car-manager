<?php
namespace Never5\WPCarManager\Helper;

abstract class Power {

	/**
	 * Returns localized power unit type label
	 *
	 * @param String $type
	 *
	 * @return string
	 */
	public static function label( $type ) {

		// return string
		$return = '';

		// translated distance units
		$translated_power_units = array(
			'kw' => __( 'kW', 'wp-car-manager' ),
			'hp' => __( 'hp', 'wp-car-manager' )
		);

		// set correct return string if exists
		if ( isset( $translated_power_units[ $type ] ) ) {
			$return = $translated_power_units[ $type ];
		}

		return $return;
	}

}