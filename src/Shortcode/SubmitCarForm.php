<?php

namespace Never5\WPCarManager\Shortcode;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

class SubmitCarForm extends Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		// parent constructor
		parent::__construct( 'submit_car_form' );
	}

	/**
	 * @param array $atts
	 *
	 * @return string
	 */
	public function output( $atts ) {
		
		// JS
		WPCarManager\Assets::enqueue_shortcode_submit_car_form();
		
		// start output buffer
		ob_start();

		wp_car_manager()->service('submit_car_handler')->display_next_step();

		return ob_get_clean();
	}

}