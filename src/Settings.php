<?php
namespace Never5\WPCarManager;

class Settings {

	/** @var array */
	private $defaults;

	/** @var array|null */
	private $options = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->set_defaults();
		$this->load_options();
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
			'summary_data'       => array(
				'condition',
				'mileage',
				'year',
				'engine',
				'fuel_type'
			)
		);
	}

	/**
	 * Load options
	 */
	private function load_options() {
		$this->options = wp_parse_args( get_option( 'wpcm_settings', array() ), $this->defaults );
	}

	/**
	 * Get option
	 *
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function get( $key ) {
		return apply_filters( 'wpcm_setting_' . $key, ( isset( $this->options[ $key ] ) ? $this->options[ $key ] : null ) );
	}

}