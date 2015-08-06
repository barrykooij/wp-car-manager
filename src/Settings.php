<?php
namespace Never5\WPCarManager;

use Never5\WPCarManager\Helper;

class Settings {

	/** @var array */
	private $fields = null;

	/** @var array */
	private $defaults;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->set_defaults();
	}

	/**
	 * Register settings
	 */
	public function register_settings() {
		foreach ( $this->get_fields() as $section ) {
			foreach ( $section[1] as $option ) {
				register_setting( 'wp-car-manager', 'wpcm_' . $option['name'] );
			}
		}
	}

	/**
	 * Sets up the setting fields
	 */
	private function setup_fields() {
		$this->fields = apply_filters( 'wpcm_fields',
			array(
				'general' => array(
					__( 'General', 'wp-car-manager' ),
					array(
						array(
							'name'    => 'currency',
							'label'   => __( 'Currency', 'wp-car-manager' ),
							'desc'    => __( 'Choose the currency used in your price fields.', 'wp-car-manager' ),
							'type'    => 'select',
							'options' => Helper\Currency::get_currencies()
						),
						array(
							'name'    => 'currency_pos',
							'label'   => __( 'Currency Position', 'wp-car-manager' ),
							'desc'    => __( '', 'wp-car-manager' ),
							'desc'    => __( 'The position of the currency symbol.', 'wp-car-manager' ),
							'type'    => 'select',
							'options' => array(
								'left'        => sprintf( __( 'Left %s', 'wp-car-manager' ), Helper\Currency::get_currency_symbol() . '99' . $this->get_option( 'decimal_separator' ) . '99' ),
								'right'       => sprintf( __( 'Right %s', 'wp-car-manager' ), '99' . $this->get_option( 'decimal_separator' ) . '99' . Helper\Currency::get_currency_symbol() ),
								'left_space'  => sprintf( __( 'Left with space %s', 'wp-car-manager' ), Helper\Currency::get_currency_symbol() . ' 99' . $this->get_option( 'decimal_separator' ) . '99' ),
								'right_space' => sprintf( __( 'Right with space %s', 'wp-car-manager' ), '99' . $this->get_option( 'decimal_separator' ) . '99 ' . Helper\Currency::get_currency_symbol() ),
							)
						),
						array(
							'name'  => 'decimal_separator',
							'label' => __( 'Decimal Separator', 'wp-car-manager' ),
							'desc'  => __( 'The decimal separator of distance unites and prices.', 'wp-car-manager' )
						),
						array(
							'name'  => 'thousand_separator',
							'label' => __( 'Thousand Separator', 'wp-car-manager' ),
							'desc'  => __( 'The thousand separator of displayed distance unites and prices.', 'wp-car-manager' )
						),
						array(
							'name'    => 'distance_unit',
							'label'   => __( 'Distance Unit', 'wp-car-manager' ),
							'desc'    => __( 'The unit type your distances are in (e.g. Mileage).', 'wp-car-manager' ),
							'type'    => 'select',
							'options' => array(
								'miles' => __( 'Miles', 'wp-car-manager' ),
								'km'    => __( 'Kilometers', 'wp-car-manager' ),
							)
						),

					),
				),
				'contact' => array(
					__( 'Contact', 'wp-car-manager' ),
					array(
						array(
							'name'  => 'contact_email',
							'label' => __( 'Contact Email Address', 'wp-car-manager' ),
							'desc'  => __( 'The email address people can send an email to.', 'wp-car-manager' )
						),
						array(
							'name'  => 'contact_phone',
							'label' => __( 'Contact Phone Number', 'wp-car-manager' ),
							'desc'  => __( 'The phone number people can call to.', 'wp-car-manager' )
						),

					),
				),
			)
		);
	}

	/**
	 * Get setting fields
	 *
	 * @return array
	 */
	public function get_fields() {
		// setup fields if null
		if ( null === $this->fields ) {
			$this->setup_fields();
		}

		return $this->fields;
	}

	/**
	 * Set defaults
	 */
	private function set_defaults() {
		$this->defaults = array(
			'currency'           => 'USD',
			'currency_pos'       => 'left',
			'decimal_separator'  => '.',
			'thousand_separator' => ',',
			'distance_unit'      => 'miles',
			'contact_email'      => get_option( 'admin_email', '' ),
			'contact_phone'      => '',
			'summary_data'       => apply_filters( 'wpcm_summary_data_fields', array(
				'condition',
				'mileage',
				'year',
				'engine',
				'fuel_type'
			) )
		);
	}

	/**
	 * Get option defaults
	 *
	 * @return array
	 */
	private function get_defaults() {
		return $this->defaults;
	}

	/**
	 * Get option
	 *
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function get_option( $key ) {
		// get option from DB
		return apply_filters( 'wpcm_get_option', get_option( 'wpcm_' . $key, ( isset( $this->defaults[ $key ] ) ? $this->defaults[ $key ] : null ) ), $key );
	}

}