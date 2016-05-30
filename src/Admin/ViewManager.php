<?php

namespace Never5\WPCarManager\Admin;

class ViewManager {

	/** @var  \Never5\WPCarManager\Pimple\Container */
	private $container;

	/**
	 * @param  \Never5\WPCarManager\Pimple\Container $c
	 */
	public function __construct( $c ) {
		$this->container = $c;
	}

	/**
	 * Display a view
	 *
	 * @param String $view
	 * @param array $vars
	 * @param String $path
	 */
	public function display( $view, $vars, $path='' ) {

		// setup variables
		extract( $vars );

		// set default path if $path is empty
		if(empty($path)) {
			$path = $this->container['file']->plugin_path() . '/assets/views/';
		}

		// setup full view path
		$view = $path. $view . '.php';

		// check if view exists
		if ( file_exists( $view ) ) {

			// load view
			include( $view );
		}
	}

}