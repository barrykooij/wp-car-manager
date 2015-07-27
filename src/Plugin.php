<?php

namespace Never5\WPCarManager;

final class Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		echo 'init';

		// new Pimple container
		$container = new Pimple\Container();

		// add post type to pimple container
		$container['post_type'] = function() {
			return new PostType();
		};

		// add post type
		add_action( 'init', function() use( $container ) {
			$container['post_type']->register();
		});

	}

}