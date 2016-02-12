<?php

namespace Never5\WPCarManager\Shortcode;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

class Dashboard extends Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		// parent constructor
		parent::__construct( 'dashboard' );
	}

	/**
	 * @param array $atts
	 *
	 * @return string
	 */
	public function output( $atts ) {

		// JS
		WPCarManager\Assets::enqueue_shortcode_dashboard();

		// get attributes, defaults filterable via 'wpcm_shortcode_dashboard_defaults' filter
		$atts = shortcode_atts( apply_filters( 'wpcm_shortcode_' . $this->get_tag() . '_defaults', array(
			'per_page'     => - 1,
			'orderby'      => 'date',
			'order'        => 'DESC',
		) ), $atts );

		// start output buffer
		ob_start();

		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard', '', array(
			'atts' => $atts,
		) );

		return ob_get_clean();
	}

}