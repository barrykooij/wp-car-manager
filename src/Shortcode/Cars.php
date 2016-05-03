<?php

namespace Never5\WPCarManager\Shortcode;

use Never5\WPCarManager\Vehicle;
use Never5\WPCarManager;

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

		// JS
		WPCarManager\Assets::enqueue_shortcode_cars();

		// get attributes, defaults filterable via 'wpcm_shortcode_cars_defaults' filter
		$atts = shortcode_atts( apply_filters( 'wpcm_shortcode_' . $this->get_tag() . '_defaults', array(
			'show_filters' => true,
			'show_sort'    => true,
			'orderby'      => 'date',
			'order'        => 'DESC',
			'make'         => '',
			'make_id'      => '',
			'sort'         => 'price-asc',
			'condition'    => '',
		) ), $atts );

		// make sure show_filters is a bool
		if ( 'false' === $atts['show_filters'] ) {
			$atts['show_filters'] = false;
		} else {
			$atts['show_filters'] = true;
		}

		// make sure show_sort is a bool
		if ( 'false' === $atts['show_sort'] ) {
			$atts['show_sort'] = false;
		} else {
			$atts['show_sort'] = true;
		}

		// check if we need to set a make_id
		if ( ! empty( $atts['make'] ) && empty( $atts['make_id'] ) ) {
			$term = get_term_by( 'name', $atts['make'], 'wpcm_make_model' );
			if ( $term != false ) {
				$atts['make_id'] = $term->term_id;
			}
		}

		// build data atts
		$data_atts = array( 'sort', 'condition', 'make_id' );
		$data_str  = '';
		foreach ( $data_atts as $data_att ) {
			if ( ! empty( $atts[ $data_att ] ) ) {
				$data_str .= ' data-' . $data_att . '="' . esc_attr( $atts[ $data_att ] ) . '"';
			}
		}

		// start output buffer
		ob_start();

		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings-vehicle', '', array(
			'atts'      => $atts,
			'data_atts' => $data_str
		) );

		return ob_get_clean();
	}

}