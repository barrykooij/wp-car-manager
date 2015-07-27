<?php

namespace Never5\WPCarManager;

final class Plugin {

	/**
	 * @var Pimple\Container
	 */
	private $container = null;

	/**
	 * Constructor
	 */
	public function __construct() {


		$this->setup_container();


		// add post type
		/*
		add_action( 'init', function() {
			$this->container['post_type']->register();
		});
		*/

		// register post type
		add_action( 'init', function () {
			PostType::register();
		} );

	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function fetch( $key ) {
		return $this->container[ $key ];
	}

	/**
	 * @param $key
	 * @param $val
	 */
	public function attach( $key, $val ) {
		$this->container[$key] = $val;
	}


	/**
	 * Setup Pimple container
	 */
	private function setup_container() {

		// new Pimple container
		$this->container = new Pimple\Container();

		// add post type to pimple container
		/*
		$this->container['post_type'] = function() {
			return new PostType();
		};
		*/
	}

}