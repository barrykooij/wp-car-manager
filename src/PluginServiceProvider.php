<?php

namespace Never5\WPCarManager;

class PluginServiceProvider implements Pimple\ServiceProviderInterface {

	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Pimple\Container $container An Container instance
	 */
	public function register( Pimple\Container $container ) {

		// view manager
		$container['view_manager'] = function ( $c ) {
			return new ViewManager( $c );
		};

		// meta box - car data
		$container['meta_box.car_data'] = function($c) {
			return new MetaBox\CarData( $c);
		};
	}

}