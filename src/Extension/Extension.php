<?php

namespace Never5\WPCarManager\Extension;

/**
 * Class Extension
 * The base class for all extensions
 */
class Extension {

	/**
	 * The store URL
	 */
	const STORE_URL = 'https://www.wpcarmanager.com/?wc-api=';

	/**
	 * Activation endpoint
	 */
	const ENDPOINT_ACTIVATION = 'license_wp_api_activation';

	/**
	 * Update endpoint
	 */
	const ENDPOINT_UPDATE = 'license_wp_api_update';

	/**
	 * @var String
	 */
	private $slug;

	/**
	 * @var String
	 */
	private $name;

	/**
	 * @var License
	 */
	private $license = null;

	/**
	 * Constructor
	 *
	 * @param String $slug
	 */
	function __construct( $slug ) {
		$this->slug = $slug;

		// The plugin file name
		$this->name = $this->slug . '/' . $this->slug . '.php';
	}

	/**
	 * @return String
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * @param String $slug
	 */
	public function set_slug( $slug ) {
		$this->slug = $slug;
	}

	/**
	 * @return String
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param String $name
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Get the license, license will be automatically loaded if not set yet.
	 *
	 * @return License
	 */
	public function get_license() {
		if ( null === $this->license ) {
			$this->license = new License( $this->slug );
		}

		return $this->license;
	}

	/**
	 * Set the license
	 *
	 * @param License $license
	 */
	public function set_license( $license ) {
		$this->license = $license;
		$this->license->store();
	}

	/**
	 * Attempt to activate a plugin licence
	 *
	 * @return String
	 */
	public function activate() {

		// Get License
		$license = $this->get_license();

		try {

			// Check License key
			if ( '' === $license->get_key() ) {
				throw new \Exception( 'Please enter your license key.' );
			}

			// Check license email
			if ( '' === $license->get_email() ) {
				throw new \Exception( 'Please enter the email address associated with your license.' );
			}

			// Do activate request
			$request = wp_remote_get( self::STORE_URL . self::ENDPOINT_ACTIVATION . '&' . http_build_query( array(
					'email'          => $license->get_email(),
					'license_key'    => $license->get_key(),
					'api_product_id' => $this->slug,
					'request'        => 'activate',
					'instance'       => site_url()
				), '', '&' ) );

			// Check request
			if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
				throw new \Exception( 'Connection failed to the Licence Key API server. Try again later.' );
			}

			// Get activation result
			$activate_results = json_decode( wp_remote_retrieve_body( $request ), true );

			// Check if response is correct
			if ( ! empty( $activate_results['activated'] ) ) {

				// Set local activation status to true
				$license->set_status( 'active' );
				$this->set_license( $license );

				// Return Message
				return array( 'result'  => 'success',
				              'message' => __( 'License successfully activated.', 'download-monitor' )
				);

			} elseif ( $activate_results === false ) {
				throw new \Exception( 'Connection failed to the Licence Key API server. Try again later.' );
			} elseif ( isset( $activate_results['error_code'] ) ) {
				throw new \Exception( $activate_results['error'] );
			}


		} catch ( \Exception $e ) {

			// Set local activation status to false
			$license->set_status( 'inactivate' );
			$this->set_license( $license );

			// Return error message
			return array( 'result' => 'failed', 'message' => $e->getMessage() );
		}
	}

	/**
	 * Attempt to deactivate a license
	 */
	public function deactivate() {

		// Get License
		$license = $this->get_license();

		try {

			// Check License key
			if ( '' === $license->get_key() ) {
				throw new \Exception( "Can't deactivate license without a license key." );
			}

			// The Request
			$request = wp_remote_get( self::STORE_URL . self::ENDPOINT_ACTIVATION . '&' . http_build_query( array(
					'api_product_id' => $this->slug,
					'license_key'    => $license->get_key(),
					'request'        => 'deactivate',
					'instance'       => site_url(),
				), '', '&' ) );

			// Check request
			if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
				throw new \Exception( 'Connection failed to the Licence Key API server. Try again later.' );
			}

			// Get result
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			/** @todo check result * */

			// Set new license status
			$license->set_status( 'inactive' );
			$this->set_license( $license );

			return array( 'result' => 'success' );

		} catch ( \Exception $e ) {

			// Return error message
			return array( 'result' => 'failed', 'message' => $e->getMessage() );
		}

	}

	/**
	 * Check for plugin updates
	 *
	 * @var $check_for_updates_data
	 */
	public function check_for_updates( $check_for_updates_data ) {

		// Get license
		$license = $this->get_license();

		// Check if checked is set
		if ( empty( $check_for_updates_data->checked ) ) {
			return $check_for_updates_data;
		}

		// Only check for data if license is activated
		if ( true !== $license->is_active() ) {
			return $check_for_updates_data;
		}

		// Get current version
		$current_ver = $check_for_updates_data->checked[ $this->name ];

		// The request
		$request = wp_remote_get( self::STORE_URL . self::ENDPOINT_UPDATE . '&' . http_build_query( array(
				'request'        => 'pluginupdatecheck',
				'plugin_name'    => $this->name,
				'version'        => $current_ver,
				'api_product_id' => $this->slug,
				'license_key'    => $license->get_key(),
				'email'          => $license->get_email(),
				'instance'       => site_url()
			), '', '&' ) );

		// Check if request is correct
		if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return $check_for_updates_data;
		}

		// Check for a plugin update
		$response = maybe_unserialize( wp_remote_retrieve_body( $request ) );

		// $response must be an object
		if ( ! is_object( $response ) ) {
			return $check_for_updates_data;
		}

		if ( isset( $response->errors ) ) {
			/** @todo handle errors */
			return $check_for_updates_data;
		}

		// Set version variables
		if ( is_object( $response ) && false !== $response && isset( $response->new_version ) ) {

			// Check if there's a new version
			if ( version_compare( $response->new_version, $current_ver, '>' ) ) {
				$check_for_updates_data->response[ $this->name ] = $response;
			}

		}

		return $check_for_updates_data;
	}

	/**
	 * Plugins API
	 *
	 * @param bool $false
	 * @param string $action
	 * @param array $args
	 *
	 * @return mixed
	 */
	public function plugins_api( $false, $action, $args ) {

		// License
		$license = $this->get_license();

		// Only take over plugin info screen if license is activated
		if ( true !== $license->is_active() ) {
			return $false;
		}

		// Check if this request if for this product
		if ( ! isset( $args->slug ) || ( $args->slug !== $this->name ) ) {
			return $false;
		}

		// Get the current version
		$plugin_info = get_site_transient( 'update_plugins' );
		$current_ver = isset( $plugin_info->checked[ $this->name ] ) ? $plugin_info->checked[ $this->name ] : '';

		$request = wp_remote_get( self::STORE_URL . self::ENDPOINT_UPDATE . '&' . http_build_query( array(
				'request'        => 'plugininformation',
				'plugin_name'    => $this->name,
				'version'        => $current_ver,
				'api_product_id' => $this->slug,
				'license_key'    => $license->get_key(),
				'email'          => $license->get_email(),
				'instance'       => site_url()
			), '', '&' ) );

		// Check if request is correct
		if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return $false;
		}

		// Check for a plugin update
		$response = maybe_unserialize( wp_remote_retrieve_body( $request ) );

		// $response must be an object
		if ( ! is_object( $response ) ) {
			return $false;
		}

		// Handle errors
		if ( isset( $response->errors ) ) {
			/** @todo handle errors */
			return $false;
		}

		// If everything is okay return the $response
		if ( isset( $response ) && is_object( $response ) && false !== $response ) {
			return $response;
		}
	}

}