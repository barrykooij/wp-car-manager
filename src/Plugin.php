<?php

namespace Never5\WPCarManager;

final class Plugin extends Pimple\Container {

	/**
	 * Constructor
	 *
	 * @string main file
	 */
	public function __construct( $file ) {

		$this['file'] = function () use ( $file ) {
			return new File( $file );
		};

		parent::__construct();

		// register services early since some add-ons need 'm
		$this->register_services();

		// load rest of classes on a later hook
		$this->load();


	}

	private function register_services() {
		$provider = new PluginServiceProvider();
		$provider->register( $this );
	}

	public function service( $key ) {
		return $this[ $key ];
	}

	/**
	 * Start loading classes on `plugins_loaded`, priority 20.
	 */
	private function load() {
		$container = $this;

		// register post type
		add_action( 'init', function () {
			PostType::register();
		} );

		if ( is_admin() ) {
			// add meta box
			add_action( 'admin_init', function () use ( $container ) {
				$container['meta_box.car_data']->init();
			} );
		}
		
	}

}