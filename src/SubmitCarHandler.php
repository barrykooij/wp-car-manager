<?php

namespace Never5\WPCarManager;

class SubmitCarHandler {

	/** @var array $steps */
	private $steps = array();

	/** @var int $step */
	private $step = 0;

	/** @var int $listing_id */
	private $listing_id = 0;

	/**
	 * Init SubmitCarHandler
	 */
	public function init() {

		// load form steps
		$this->load_steps();

		// get and set current step
		$this->set_current_step();

		// get and set current listing (car) id
		$this->set_listing_id();

		// process current action
		$this->process();
	}

	/**
	 * Process current actions
	 */
	private function process() {

		// get current step data
		$step_data = $this->get_current_step_data();

		// check if handler is defined
		if ( isset( $step_data['handler'] ) && is_callable( $step_data['handler'] ) ) {

			// call handler
			call_user_func( $step_data['handler'] );
		}
	}

	/**
	 * Display next step
	 */
	public function display_next_step() {

		// increment step
		$this->step ++;

		// get current step data
		$step_data = $this->get_current_step_data();

		// check if view is defined
		if ( isset( $step_data['view'] ) && is_callable( $step_data['view'] ) ) {

			// call handler
			call_user_func( $step_data['view'] );
		}

	}

	/**
	 * Get current step data
	 *
	 * @return array
	 */
	public function get_current_step_data() {

		// get current step key
		$current_step_key = $this->get_current_step_key();

		// check if current step exists in keys and if so, return it
		if ( isset( $this->steps[ $current_step_key ] ) ) {
			return $this->steps[ $current_step_key ];
		}

		// return empty array
		return array();
	}

	/**
	 * Get current step key
	 *
	 * @return string
	 */
	public function get_current_step_key() {

		$step_key = '';

		// get step keys
		$step_keys = array_keys( $this->steps );

		// check if step key exists, if it does set it in $step_key
		if ( isset( $step_keys[ $this->step - 1 ] ) ) {
			$step_key = $step_keys[ $this->step - 1 ];
		}

		// return step_key
		return $step_key;
	}

	/**
	 * Load form steps
	 */
	private function load_steps() {

		// setup default steps, make filterable
		$this->steps = (array) apply_filters( 'wpcm_submit_car_form_steps', array(
			'form'    => array(
				'view'     => array( $this, 'view_form' ),
				'priority' => 10
			),
			'preview' => array(
				'view'     => array( $this, 'view_preview' ),
				'priority' => 20
			),
			'done'    => array(
				'view'     => array( $this, 'view_done' ),
				'priority' => 30
			),
		) );

		// sort steps by priority
		uasort( $this->steps, array( $this, 'sort_by_priority' ) );
	}

	/**
	 * Find and set the current step
	 */
	private function set_current_step() {
		if ( isset( $_POST['wpcm_step'] ) ) {
			$this->step = absint( $_POST['wpcm_step'] );
		} else if ( isset( $_GET['wpcm_step'] ) ) {
			$this->step = absint( $_GET['wpcm_step'] );
		}
	}

	/**
	 * Find and set current listing id
	 */
	private function set_listing_id() {
		if ( isset( $_POST['wpcm_vehicle_id'] ) ) {
			$this->listing_id = absint( $_POST['wpcm_vehicle_id'] );
		} else if ( isset( $_GET['wpcm_vehicle_id'] ) ) {
			$this->listing_id = absint( $_GET['wpcm_vehicle_id'] );
		}
	}


	/**
	 * Sort array by priority value
	 *
	 * @param array $a
	 * @param array $b
	 *
	 * @return int
	 */
	public function sort_by_priority( $a, $b ) {
		if ( $a['priority'] == $b['priority'] ) {
			return 0;
		}

		return ( $a['priority'] < $b['priority'] ) ? - 1 : 1;
	}

	/**
	 * VIEWS
	 */

	/**
	 * Form view
	 */
	public function view_form() {

		// get listing id (0 if new)
		$listing_id = ( ( ! empty( $_GET['edit'] ) ) ? absint( $_GET['edit'] ) : 0 );

		/** @var Vehicle\Car $vehicle */
		try {
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $listing_id );

			// load template
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form', '', array(
				'vehicle'            => $vehicle,
				'action'             => add_query_arg( 'wpcm_step', 1, site_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) ),
				'submit_button_text' => ( ( 0 != $vehicle->get_id() ) ? __( 'Save Changes', 'wp-car-manager' ) : __( 'Preview Car', 'wp-car-manager' ) ),
				'can_post_listing'   => wp_car_manager()->service( 'user_manager' )->can_post_listing(),
				'can_edit_listing'   => wp_car_manager()->service( 'user_manager' )->can_edit_listing( $listing_id ),
			) );
		} catch ( \Exception $e ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/disabled', '' );
		}
	}

	/**
	 * Preview view
	 */
	public function view_preview() {

		// get listing id (0 if new)
		$listing_id = ( ( ! empty( $_GET['vehicle_id'] ) ) ? absint( $_GET['vehicle_id'] ) : 0 );

		if ( $listing_id > 0 ) {
			/** @var Vehicle\Car $vehicle */
			try {
				$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $listing_id );

				// we need an extra wrapper because the native single template adds the 'wpcm_vehicle' class to the article wrapper
				echo '<div class="wpcm_vehicle">';

				// load template
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'content-single-vehicle', '', array(
					'vehicle' => $vehicle
				) );

				// end extra wrapper
				echo "</div>";
			} catch ( \Exception $e ) {
				wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/disabled', '' );
			}
		}

	}
}