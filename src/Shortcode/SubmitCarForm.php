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

		// get listing id (0 if new)
		$listing_id = ( ( ! empty( $_GET['edit'] ) ) ? absint( $_GET['edit'] ) : 0 );

		// start output buffer
		ob_start();

		/** @var Vehicle\Car $vehicle */
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $listing_id );

		// @todo check if we can set vehicle data based on POST data if $listing_id is 0

		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form', '', array(
			'vehicle'            => $vehicle,
			'action'             => esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
			'submit_button_text' => ( ( 0 != $vehicle->get_id() ) ? __( 'Save Changes', 'wp-car-manager' ) : __( 'Preview Car', 'wp-car-manager' ) ),
			'can_post_listing'   => wp_car_manager()->service( 'user_manager' )->can_post_listing(),
			'can_edit_listing'   => wp_car_manager()->service( 'user_manager' )->can_edit_listing( $listing_id ),
		) );

		return ob_get_clean();
	}

}