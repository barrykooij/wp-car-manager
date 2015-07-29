<?php
namespace Never5\WPCarManager\Helper;

use Never5\WPCarManager\Plugin;

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
			'decimal_separator'  => $wpcm->service( 'settings' )->get( 'decimal_separator' ),
			'thousand_separator' => $wpcm->service( 'settings' )->get( 'thousand_separator' ),
			'decimals'           => 0,
			'price_format'       => Price::get_price_format()
		) ) );

		$negative = $price < 0;
		$price    = floatval( $negative ? $price * - 1 : $price );
		$price    = number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], Currency::get_currency_symbol(), $price );
		$return          = '<span class="amount">' . $formatted_price . '</span>';

		return $return;
	}

}