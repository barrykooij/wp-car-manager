<?php

namespace Never5\WPCarManager\Shortcode;

class Cars extends Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'cars' );
	}

	/**
	 * @param array $atts
	 *
	 * @return string
	 */
	public function output( $atts ) {

		// get attributes, defaults filterable via 'wpcm_shortcode_cars_defaults' filter
		$atts = shortcode_atts( apply_filters( 'wpcm_shortcode_' . $this->get_tag() . '_defaults', array(
			'per_page' => 12, // @todo make this a setting later
			'orderby'  => 'date',
			'order'    => 'DESC',
		) ), $atts );

		// start output buffer
		ob_start();

		wp_car_manager()->service( 'template_manager' )->get_template_part( 'archive-vehicle', '', array(
			'atts' => $atts
		) );

		return ob_get_clean();
	}

}