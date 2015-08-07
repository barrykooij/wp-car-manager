<?php

namespace Never5\WPCarManager\Ajax;

abstract class Ajax {

	private $tag = '';

	/**
	 * @param string $tag
	 */
	public function __construct( $tag ) {
		$this->tag = $tag;
	}

	/**
	 * Register AJAX action
	 */
	public function register() {
		add_action( Manager::ENDPOINT . $this->tag, array( $this, 'run' ) );
	}

	/**
	 * AJAX callback method, must be overridden
	 *
	 * @return void
	 */
	public abstract function run();

}