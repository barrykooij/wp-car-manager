<?php

namespace Never5\WPCarManager\Extension;

class Manager {

	/**
	 * @var Manager
	 */
	private static $instance = null;

	/**
	 * @var array<Extension>
	 */
	private $extensions;

	/**
	 * Private constructor
	 */
	private function __construct() {
	}

	/**
	 * Singleton get method
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return Manager
	 */
	public static function get() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Load Extensions
	 *
	 * @param array $extension_slugs
	 */
	public function load_extensions( $extension_slugs ) {

		// Check
		if ( count( $extension_slugs ) > 0 ) {

			// Loop
			foreach ( $extension_slugs as $extension_slug ) {

				// Setup new Product
				$extension = new Extension( $extension_slug );

				// Setup plugin actions and filters
				add_action( 'pre_set_site_transient_update_plugins', array( $extension, 'check_for_updates' ) );
				add_filter( 'plugins_api', array( $extension, 'plugins_api' ), 10, 3 );

				// Add product to products property
				$this->extensions[ $extension_slug ] = $extension;
			}

		}

	}

	/**
	 * Get products
	 *
	 * @return array<Extension>
	 */
	public function get_extensions() {
		return $this->extensions;
	}

}