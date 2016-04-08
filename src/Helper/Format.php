<?php
namespace Never5\WPCarManager\Helper;

use Never5\WPCarManager\Plugin;
use Never5\WPCarManager\Settings;

abstract class Format {

	/**
	 * Format price
	 *
	 * @param float $price
	 * @param array $args
	 *
	 * @return string
	 */
	public static function price( $price, $args = array() ) {

		/** @var Plugin $wpcm */
		$wpcm = wp_car_manager();

		$args = apply_filters( 'wpcm_format_price_args', wp_parse_args( $args, array(
			'ex_tax_label'       => false,
			'currency'           => '',
			'decimal_separator'  => $wpcm->service( 'settings' )->get_option( 'decimal_separator' ),
			'thousand_separator' => $wpcm->service( 'settings' )->get_option( 'thousand_separator' ),
			'decimals'           => 0,
			'price_format'       => Price::get_price_format(),
			'plain'              => false,
		) ) );

		$negative = $price < 0;
		$price    = floatval( $negative ? $price * - 1 : $price );
		$price    = number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], Currency::get_currency_symbol(), $price );

		$return = '';

		// add span
		if ( ! $args['plain'] ) {
			$return .= '<span class="amount">';
		}

		// add price
		$return .= $formatted_price;

		// close span
		if ( ! $args['plain'] ) {
			$return .= '</span>';
		}

		return $return;
	}

	/**
	 * Formats mileage
	 *
	 * @param $mileage
	 *
	 * @return string
	 */
	public static function mileage( $mileage ) {
		/** @var Settings $settings */
		$settings = wp_car_manager()->service( 'settings' );

		// translated distance units
		$translated_distance_units = array(
			'miles' => __( 'miles', 'wp-car-manager' ),
			'km'    => __( 'km', 'wp-car-manager' )
		);

		return number_format( $mileage ? $mileage : 0, 0, $settings->get_option( 'decimal_separator' ), $settings->get_option( 'thousand_separator' ) ) . ' ' . $translated_distance_units[ $settings->get_option( 'distance_unit' ) ];
	}

}