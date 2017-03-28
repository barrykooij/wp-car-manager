<?php
namespace Never5\WPCarManager\Helper;

/**
 * Class Currency
 * @package Never5\WPCarManager\Helper
 *
 */
abstract class Currency {

	/**
	 * Get currency symbol of given currency.
	 * Uses setting's currency if no currency is given
	 *
	 * Forked from WooCommerce's get_woocommerce_currency_symbol():
	 * https://github.com/woothemes/woocommerce/blob/9e41552342d07796d3ee5cefea76935288b65c6e/includes/wc-core-functions.php#L314
	 *
	 * @param string $currency
	 *
	 * @return String
	 */
	public static function get_currency_symbol( $currency = '' ) {

		// use default currency if currency arg not given
		if ( ! $currency ) {
			$currency = wp_car_manager()->service( 'settings' )->get_option( 'currency' );
		}

		switch ( $currency ) {
			case 'AED' :
				$currency_symbol = 'د.إ';
				break;
			case 'AUD' :
			case 'CAD' :
			case 'CLP' :
			case 'COP' :
			case 'HKD' :
			case 'MXN' :
			case 'NZD' :
			case 'SGD' :
			case 'USD' :
				$currency_symbol = '&#36;';
				break;
			case 'BDT':
				$currency_symbol = '&#2547;&nbsp;';
				break;
			case 'BGN' :
				$currency_symbol = '&#1083;&#1074;.';
				break;
			case 'BIF':
				$currency_symbol = 'FBu';
				break;
			case 'BRL' :
				$currency_symbol = '&#82;&#36;';
				break;
			case 'CHF' :
				$currency_symbol = '&#67;&#72;&#70;';
				break;
			case 'CNY' :
			case 'JPY' :
			case 'RMB' :
				$currency_symbol = '&yen;';
				break;
			case 'CZK' :
				$currency_symbol = '&#75;&#269;';
				break;
			case 'DJF':
				$currency_symbol = 'Fdj';
				break;
			case 'DKK' :
				$currency_symbol = 'DKK';
				break;
			case 'DOP' :
				$currency_symbol = 'RD&#36;';
				break;
			case 'EGP' :
				$currency_symbol = 'EGP';
				break;
			case 'ETB':
				$currency_symbol = 'ETB';
				break;
			case 'EUR' :
				$currency_symbol = '&euro;';
				break;
			case 'GBP' :
				$currency_symbol = '&pound;';
				break;
			case 'GHS':
				$currency_symbol = 'GH₵';
				break;
			case 'HRK' :
				$currency_symbol = 'Kn';
				break;
			case 'HUF' :
				$currency_symbol = '&#70;&#116;';
				break;
			case 'IDR' :
				$currency_symbol = 'Rp';
				break;
			case 'ILS' :
				$currency_symbol = '&#8362;';
				break;
			case 'INR' :
				$currency_symbol = 'Rs.';
				break;
			case 'ISK' :
				$currency_symbol = 'Kr.';
				break;
			case 'KES':
				$currency_symbol = 'KSh';
				break;
			case 'KIP' :
				$currency_symbol = '&#8365;';
				break;
			case 'KRW' :
				$currency_symbol = '&#8361;';
				break;
			case 'MYR' :
				$currency_symbol = '&#82;&#77;';
				break;
			case 'NGN' :
				$currency_symbol = '&#8358;';
				break;
			case 'NOK' :
				$currency_symbol = '&#107;&#114;';
				break;
			case 'NPR' :
				$currency_symbol = 'Rs.';
				break;
			case 'PHP' :
				$currency_symbol = '&#8369;';
				break;
			case 'PKR' :
				$currency_symbol = 'Rs.';
				break;
			case 'PLN' :
				$currency_symbol = '&#122;&#322;';
				break;
			case 'PYG' :
				$currency_symbol = '&#8370;';
				break;
			case 'RON' :
				$currency_symbol = 'lei';
				break;
			case 'RUB' :
				$currency_symbol = '&#1088;&#1091;&#1073;.';
				break;
			case 'RWF':
				$currency_symbol = 'FRw';
				break;
			case 'SEK' :
				$currency_symbol = '&#107;&#114;';
				break;
			case 'THB' :
				$currency_symbol = '&#3647;';
				break;
			case 'TND' :
				$currency_symbol = 'DT';
				break;
			case 'TRY' :
				$currency_symbol = '&#8378;';
				break;
			case 'TWD' :
				$currency_symbol = '&#78;&#84;&#36;';
				break;
			case 'TZS':
				$currency_symbol = 'TSh';
				break;
			case 'UAH' :
				$currency_symbol = '&#8372;';
				break;
			case 'UGX':
				$currency_symbol = 'USh';
				break;
			case 'VND' :
				$currency_symbol = '&#8363;';
				break;
			case 'XAF':
				$currency_symbol = 'CFA';
				break;
			case 'ZAR' :
				$currency_symbol = '&#82;';
				break;
			default :
				$currency_symbol = '';
				break;
		}

		return apply_filters( 'wpcm_currency_symbol', $currency_symbol, $currency );
	}

	/**
	 * Get currency position
	 *
	 * @return String
	 */
	public static function get_currency_position() {
		return wp_car_manager()->service( 'settings' )->get_option( 'currency_position' );
	}

	/**
	 * Return available currencies
	 *
	 * @return array
	 */
	public static function get_currencies() {
		return array_unique(
			apply_filters( 'wpcm_currencies',
				array(
					'ARS' => __( 'Argentine Peso', 'wp-car-manager' ),
					'AUD' => __( 'Australian Dollars', 'wp-car-manager' ),
					'BDT' => __( 'Bangladeshi Taka', 'wp-car-manager' ),
					'BRL' => __( 'Brazilian Real', 'wp-car-manager' ),
					'BGN' => __( 'Bulgarian Lev', 'wp-car-manager' ),
					'BIF' => __( 'Burundian Franc', 'wp-car-manager' ),
					'CAD' => __( 'Canadian Dollars', 'wp-car-manager' ),
					'XAF' => __( 'CFA Franc', 'wp-car-manager' ),
					'CLP' => __( 'Chilean Peso', 'wp-car-manager' ),
					'CNY' => __( 'Chinese Yuan', 'wp-car-manager' ),
					'COP' => __( 'Colombian Peso', 'wp-car-manager' ),
					'CZK' => __( 'Czech Koruna', 'wp-car-manager' ),
					'DJF' => __( 'Djiboutian Franc', 'wp-car-manager' ),
					'DKK' => __( 'Danish Krone', 'wp-car-manager' ),
					'DOP' => __( 'Dominican Peso', 'wp-car-manager' ),
					'ETB' => __( 'Ethiopian Birr', 'wp-car-manager' ),
					'EGP' => __( 'Egyptian Pound', 'wp-car-manager' ),
					'EUR' => __( 'Euros', 'wp-car-manager' ),
					'GHS' => __( 'Ghanaian Cedi', 'wp-car-manager' ),
					'HKD' => __( 'Hong Kong Dollar', 'wp-car-manager' ),
					'HRK' => __( 'Croatia kuna', 'wp-car-manager' ),
					'HUF' => __( 'Hungarian Forint', 'wp-car-manager' ),
					'ISK' => __( 'Icelandic krona', 'wp-car-manager' ),
					'IDR' => __( 'Indonesia Rupiah', 'wp-car-manager' ),
					'INR' => __( 'Indian Rupee', 'wp-car-manager' ),
					'ILS' => __( 'Israeli Shekel', 'wp-car-manager' ),
					'JPY' => __( 'Japanese Yen', 'wp-car-manager' ),
					'KES' => __( 'Kenyan Shilling', 'wp-car-manager'),
					'KIP' => __( 'Lao Kip', 'wp-car-manager' ),
					'KRW' => __( 'South Korean Won', 'wp-car-manager' ),
					'MYR' => __( 'Malaysian Ringgits', 'wp-car-manager' ),
					'MXN' => __( 'Mexican Peso', 'wp-car-manager' ),
					'NGN' => __( 'Nigerian Naira', 'wp-car-manager' ),
					'NOK' => __( 'Norwegian Krone', 'wp-car-manager' ),
					'NPR' => __( 'Nepali Rupee', 'wp-car-manager' ),
					'NZD' => __( 'New Zealand Dollar', 'wp-car-manager' ),
					'PHP' => __( 'Philippine Pesos', 'wp-car-manager' ),
					'PKR' => __( 'Pakistani Rupee', 'wp-car-manager' ),
					'PLN' => __( 'Polish Zloty', 'wp-car-manager' ),
					'PYG' => __( 'Paraguayan Guaraní', 'wp-car-manager' ),
					'GBP' => __( 'Pounds Sterling', 'wp-car-manager' ),
					'RON' => __( 'Romanian Leu', 'wp-car-manager' ),
					'RUB' => __( 'Russian Ruble', 'wp-car-manager' ),
					'RWF' => __( 'Rwandan Franc', 'wp-car-manager' ),
					'SGD' => __( 'Singapore Dollar', 'wp-car-manager' ),
					'ZAR' => __( 'South African rand', 'wp-car-manager' ),
					'SEK' => __( 'Swedish Krona', 'wp-car-manager' ),
					'CHF' => __( 'Swiss Franc', 'wp-car-manager' ),
					'THB' => __( 'Thai Baht', 'wp-car-manager' ),
					'TND' => __( 'Tunisian Dinar', 'wp-car-manager' ),
					'TRY' => __( 'Turkish Lira', 'wp-car-manager' ),
					'TWD' => __( 'Taiwan New Dollars', 'wp-car-manager' ),
					'TZS' => __( 'Tanzanian Shilling', 'wp-car-manager' ),
					'UAH' => __( 'Ukrainian Hryvnia', 'wp-car-manager' ),
					'UGX' => __( 'Ugandan Shilling', 'wp-car-manager' ),
					'AED' => __( 'United Arab Emirates Dirham', 'wp-car-manager' ),
					'USD' => __( 'US Dollars', 'wp-car-manager' ),
					'VND' => __( 'Vietnamese Dong', 'wp-car-manager' )
				)
			)
		);
	}

}
