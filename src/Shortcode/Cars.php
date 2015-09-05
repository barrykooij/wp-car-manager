<?php

namespace Never5\WPCarManager\Shortcode;

use Never5\WPCarManager\Vehicle;

class Cars extends Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {

		// parent constructor
		parent::__construct( 'cars' );

		// add rewrite tags for this shortcode
		add_rewrite_tag( '%make%', '([^&]+)' );
		add_rewrite_tag( '%model%', '([^&]+)' );
		add_rewrite_tag( '%price_from%', '([^&]+)' );
		add_rewrite_tag( '%price_to%', '([^&]+)' );
		add_rewrite_tag( '%mileage_from%', '([^&]+)' );
		add_rewrite_tag( '%mileage_to%', '([^&]+)' );
		add_rewrite_tag( '%frdate_from%', '([^&]+)' );
		add_rewrite_tag( '%frdate_to%', '([^&]+)' );
	}

	/**
	 * @param array $atts
	 *
	 * @return string
	 */
	public function output( $atts ) {

		// get attributes, defaults filterable via 'wpcm_shortcode_cars_defaults' filter
		$atts = shortcode_atts( apply_filters( 'wpcm_shortcode_' . $this->get_tag() . '_defaults', array(
			'show_filters' => true,
			'per_page'     => - 1, // @todo make this a setting later
			'orderby'      => 'date',
			'order'        => 'DESC',
		) ), $atts );

		// make sure show_filters is a bool
		if ( 'false' == $atts['show_filters'] ) {
			$atts['show_filters'] = false;
		} else {
			$atts['show_filters'] = true;
		}

		// start output buffer
		ob_start();

		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings-vehicle', '', array(
			'atts' => $atts,
		) );

		return ob_get_clean();
	}

}