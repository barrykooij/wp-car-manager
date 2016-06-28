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
				'general'    => array(
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
						array(
							'name'  => 'date_format',
							'label' => __( 'Date Format', 'wp-car-manager' ),
							'desc'  => __( 'The way dates are formatted.', 'wp-car-manager' )
						),

					),
				),
				'listings'   => array(
					__( 'Listings', 'wp-car-manager' ),
					array(
						array(
							'name'     => 'listings_hide_sold',
							'label'    => __( 'Hide Sold Listings', 'wp-car-manager' ),
							'cb_label' => __( 'Hide sold listings from listing pages', 'wp-car-manager' ),
							'desc'     => __( 'If enabled, listings marked as sold will no longer be listed on your listing pages.', 'wp-car-manager' ),
							'type'     => 'checkbox',
						),
						array(
							'name'  => 'listings_ppp',
							'label' => __( 'Listings Per Page', 'wp-car-manager' ),
							'desc'  => sprintf( __( 'The amount of listings per page. Enter %s to disable pagination.', 'wp-car-manager' ), '<code>-1</code>' )
						),

					),
				),
				'submission' => array(
					__( 'Submission', 'wp-car-manager' ),
					array(
						array(
							'name'     => 'account_creation',
							'label'    => __( 'Account Creation', 'wp-car-manager' ),
							'cb_label' => __( 'Allow account creation', 'wp-car-manager' ),
							'desc'     => __( 'If enabled, non-logged in users will be able to create an account by entering their email address on the submission form.', 'wp-car-manager' ),
							'type'     => 'checkbox',
						),
						array(
							'name'     => 'account_username',
							'label'    => __( 'Account Username', 'wp-car-manager' ),
							'cb_label' => __( 'Automatically Generate Username from Email Address', 'wp-car-manager' ),
							'desc'     => __( 'If enabled, a username will be generated from the first part of the user email address. Otherwise, a username field will be shown.', 'wp-car-manager' ),
							'type'     => 'checkbox',
						),
						array(
							'name'    => 'account_role',
							'label'   => __( 'Account Role', 'wp-car-manager' ),
							'desc'    => __( 'If you enable registration on your submission form, choose a role for the new user.', 'wp-car-manager' ),
							'type'    => 'select',
							'options' => Helper\Roles::get_roles()
						),
						array(
							'name'     => 'moderate_new_listings',
							'label'    => __( 'Moderate New Listings', 'wp-car-manager' ),
							'cb_label' => __( 'New listing submissions require admin approval', 'wp-car-manager' ),
							'desc'     => __( 'If enabled, new submissions will be inactive, pending admin approval.', 'wp-car-manager' ),
							'type'     => 'checkbox',
						),
						array(
							'name'  => 'listing_duration',
							'label' => __( 'Listing Duration', 'wp-car-manager' ),
							'desc'  => sprintf( __( 'How many %sdays%s listings are live before expiring. Can be left blank to never expire.', 'wp-car-manager' ), '<strong>', '</strong>' )
						),

					),
				),
				'contact'    => array(
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
				'pages'      => array(
					__( 'Pages', 'wp-car-manager' ),
					array(
						array(
							'name'    => 'page_submit',
							'label'   => __( 'Submit Car Page Form', 'wp-car-manager' ),
							'desc'    => sprintf( __( 'Select the page where you have placed the %s shortcode.', 'wp-car-manager' ), '<a href="https://www.wpcarmanager.com/kb/submit-car-form/" target="_blank">[wpcm_submit_car_form]</a>' ),
							'type'    => 'select',
							'options' => Helper\Pages::get_pages()
						),
						array(
							'name'    => 'page_dashboard',
							'label'   => __( 'Car Dashboard Page', 'wp-car-manager' ),
							'desc'    => sprintf( __( 'Select the page where you have placed the %s shortcode.', 'wp-car-manager' ), '<a href="https://www.wpcarmanager.com/kb/car-dashboard/" target="_blank">[wpcm_dashboard]</a>' ),
							'type'    => 'select',
							'options' => Helper\Pages::get_pages()
						),
						array(
							'name'    => 'page_listings',
							'label'   => __( 'Car Listings Page', 'wp-car-manager' ),
							'desc'    => sprintf( __( 'Select the page where you have placed the %s shortcode.', 'wp-car-manager' ), '<a href="https://www.wpcarmanager.com/kb/listings-page/" target="_blank">[wpcm_cars]</a>' ),
							'type'    => 'select',
							'options' => Helper\Pages::get_pages()
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
			'currency'              => 'USD',
			'currency_pos'          => 'left',
			'decimal_separator'     => '.',
			'thousand_separator'    => ',',
			'distance_unit'         => 'miles',
			'date_format'           => 'm-Y',
			'contact_email'         => get_option( 'admin_email', '' ),
			'contact_phone'         => '',
			'summary_data'          => apply_filters( 'wpcm_summary_data_fields', array(
				'condition',
				'mileage',
				'frdate',
				'engine',
				'fuel_type'
			) ),
			'account_creation'      => '1',
			'account_username'      => '1',
			'account_role'          => 'car_seller',
			'moderate_new_listings' => '1',
			'listing_duration'      => '30',
			'page_submit'           => 0,
			'page_dashboard'        => 0,
			'page_listings'         => 0,
			'listings_hide_sold'    => 0,
			'listings_ppp'          => 10,
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