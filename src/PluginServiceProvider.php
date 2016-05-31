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
			return new Admin\ViewManager( $c );
		};

		// vehicle factory
		$container['vehicle_repository'] = function () {
			return new Vehicle\WordPressRepository();
		};

		// vehicle factory
		$container['vehicle_factory'] = function ( $c ) {
			return new Vehicle\VehicleFactory( $c['vehicle_repository'] );
		};

		// template manger
		$container['template_manager'] = function () {
			return new TemplateManager();
		};

		// settings
		$container['settings'] = function () {
			return new Settings();
		};

		// MakeModelManager
		$container['make_model_manager'] = function () {
			return new MakeModelManager();
		};

		// UserManager
		$container['user_manager'] = function () {
			return new UserManager();
		};

		// SubmitCarHandler
		$container['submit_car_handler'] = function () {
			return new SubmitCarHandler();
		};
	}

}