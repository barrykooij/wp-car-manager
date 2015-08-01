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
	 */
	public function display( $view, $vars ) {

		// setup variables
		extract( $vars );

		// setup full view path
		$view = $this->container['file']->plugin_path() . '/assets/views/' . $view . '.php';

		// check if view exists
		if ( file_exists( $view ) ) {

			// load view
			include( $view );
		}
	}

}