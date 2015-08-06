<?php

namespace Never5\WPCarManager\Shortcode;

abstract class Shortcode {

	/** @var string */
	private $tag = '';

	/**
	 * @param $tag
	 */
	public function __construct( $tag ) {
		$this->tag = $tag;
		$this->setup();
	}

	/**
	 * @return string
	 */
	protected function get_tag() {
		return $this->tag;
	}

	/**
	 * Setup the shortcode
	 */
	private function setup() {
		add_shortcode( 'wpcm_' . $this->tag, array( $this, 'output' ) );
	}

}