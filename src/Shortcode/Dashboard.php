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
			'orderby'  => 'date',
			'order'    => 'DESC',
		) ), $atts );

		// start output buffer
		ob_start();

		if ( is_user_logged_in() ) {
			// load dashboard template
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard', '', array(
				'atts' => $atts,
			) );
		} else {
			// load not logged in template
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/not-logged-in', '', array(
				'atts' => $atts,
			) );
		}
		
		return ob_get_clean();
	}

}