<?php

namespace Never5\WPCarManager;

final class Plugin extends Pimple\Container {

	/** @var string */
	private $version = '1.0';

	/**
	 * Constructor
	 *
	 * @param string $version
	 * @param string $file
	 */
	public function __construct( $version, $file ) {

		// set version
		$this->version = $version;

		// Pimple Container construct
		parent::__construct();

		// register file service
		$this['file'] = function () use ( $file ) {
			return new File( $file );
		};

		// register services early since some add-ons need 'm
		$this->register_services();

		// load the plugin
		$this->load();


	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register services
	 */
	private function register_services() {
		$provider = new PluginServiceProvider();
		$provider->register( $this );
	}

	/**
	 * Get service
	 *
	 * @param String $key
	 *
	 * @return mixed
	 */
	public function service( $key ) {
		return $this[ $key ];
	}

	/**
	 * Start loading classes on `plugins_loaded`, priority 20.
	 */
	private function load() {
		$container = $this;

		// register post type & taxonomies
		add_action( 'init', function () {
			PostType::register();
			Taxonomies::register_model_make();
			Taxonomies::register_features();
		} );

		if ( is_admin() ) {

			// add admin menu
			add_action('admin_menu', function() {
				$page_makes = new Admin\Page\Makes();
				$page_makes->init();
			});

			// add meta box
			add_action( 'admin_init', function () {

				// car data
				$car_data = new Admin\MetaBox\CarData();
				$car_data->init();

				// short description
				if ( function_exists( 'wp_editor' ) ) {
					$short_description = new Admin\MetaBox\ShortDescription();
					$short_description->init();
				}

			} );

			// assets
			add_action( 'admin_enqueue_scripts', array( 'Never5\\WPCarManager\\Assets', 'enqueue_backend' ) );
		} else {

			// Include template functions
			require_once( $container['file']->plugin_path() . '/includes/template-hooks.php' );
			require_once( $container['file']->plugin_path() . '/includes/template-functions.php' );

			// init template manager to enable template overrides
			$container['template_manager']->init();

			// assets
			add_action( 'wp_enqueue_scripts', array( 'Never5\\WPCarManager\\Assets', 'enqueue_frontend' ) );

		}

	}

}