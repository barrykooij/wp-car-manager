<?php

namespace Never5\WPCarManager;

class SubmitCarHandler {

	/** @var array $steps */
	private $steps = array();

	/** @var int $step */
	private $step = 0;

	/** @var int $listing_id */
	private $listing_id = 0;

	/** @var bool True if we're editing a listing */
	private $is_edit = false;

	/**
	 * Init SubmitCarHandler
	 */
	public function init() {

		// check if we're editing
		if ( ! empty( $_GET['wpcm_edit'] ) && ! empty( $_GET['wpcm_vehicle_id'] ) ) {
			$this->is_edit = true;
		}

		// set vehicle ID
		if ( ! empty( $_GET['wpcm_vehicle_id'] ) ) {
			$this->listing_id = absint( $_GET['wpcm_vehicle_id'] );
		}

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
		if ( isset( $step_data['view'] ) ) {


			if ( is_callable( $step_data['view'] ) ) {
				// call handler
				call_user_func( $step_data['view'] );
			} else if ( false === $step_data['view'] ) {
				// no view in current step, setup redirect to next step so we invoke process
				$this->view_empty_redirect();
			}

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

		// default steps
		$default_steps = array(
			'form' => array(
				'view'     => array( $this, 'view_form' ),
				'priority' => 10
			),
			'done' => array(
				'view'     => array( $this, 'view_done' ),
				'priority' => 30
			),
		);

		// check if edit
		if ( ! $this->is_edit ) {

			// add preview step to 'new' listing steps (editing has no preview)
			$default_steps['preview'] = array(
				'view'     => array( $this, 'view_preview' ),
				'handler'  => array( $this, 'process_new_listing' ),
				'priority' => 20
			);

			// apply add filters
			$this->steps = (array) apply_filters( 'wpcm_submit_car_form_steps_new', $default_steps );
		} else {
			// apply edit filters
			$this->steps = (array) apply_filters( 'wpcm_submit_car_form_steps_edit', $default_steps );
		}


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
	 * If a view is empty we setup a redirect to next step to kick in it's processing action
	 */
	public function view_empty_redirect() {
		// load template
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/step-empty-view', '', array(
			'step'         => $this->step,
			'step_key'     => $this->get_current_step_key(),
			'listing_id'   => $this->listing_id,
			'redirect_url' => add_query_arg( array(
				'wpcm_step'       => $this->step,
				'wpcm_vehicle_id' => $this->listing_id,
			), \Never5\WPCarManager\Helper\Pages::get_page_submit() )
		) );
	}

	/**
	 * Form view
	 */
	public function view_form() {

		/** @var Vehicle\Car $vehicle */
		try {
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $this->listing_id );

			// setup action URL
			$action_url = add_query_arg( 'wpcm_step', $this->step, \Never5\WPCarManager\Helper\Pages::get_page_submit() );

			// check we're in edit
			if ( $this->is_edit ) {
				$action_url = add_query_arg( array(
					'wpcm_edit'       => 1,
					'wpcm_vehicle_id' => $this->listing_id
				), $action_url );
			}

			// load template
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form', '', array(
				'vehicle'            => $vehicle,
				'action'             => $action_url,
				'submit_button_text' => ( ( 0 != $vehicle->get_id() ) ? __( 'Save Changes', 'wp-car-manager' ) : __( 'Preview Car', 'wp-car-manager' ) ),
				'can_post_listing'   => wp_car_manager()->service( 'user_manager' )->can_post_listing(),
				'can_edit_listing'   => wp_car_manager()->service( 'user_manager' )->can_edit_listing( $this->listing_id ),
			) );
		} catch ( \Exception $e ) {
			wp_car_manager()->service( 'template_manager' )->get_template_part( 'submit-car-form/disabled', '' );
		}
	}

	/**
	 * Preview view
	 */
	public function view_preview() {

		// get listing id
		$listing_id = ( ( ! empty( $_GET['wpcm_vehicle_id'] ) ) ? absint( $_GET['wpcm_vehicle_id'] ) : 0 );

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

	/**
	 * Process a new listing, called after the view_preview() method
	 */
	public function process_new_listing() {

		// vehicle ID that is requested to publish
		$vehicle_id = $this->listing_id;

		// redirect user to login screen if they can't edit this listing
		if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id ) ) {
			wp_redirect( wp_login_url( add_query_arg( 'wpcm_publish', $vehicle_id ) ) );
			exit;
		}

		// get vehicle object
		/** @var Vehicle $vehicle */
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $vehicle_id );

		// set vehicle status
		$new_status = ( ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'moderate_new_listings' ) ) ? 'pending' : 'publish' );
		$new_status = apply_filters( 'wpcm_submit_publish_action_status', $new_status, $vehicle );
		$vehicle->set_status( $new_status );

		// save vehicle
		wp_car_manager()->service( 'vehicle_repository' )->persist( $vehicle );
	}

	/**
	 * Done view
	 */
	public function view_done() {

		// get listing id
		$listing_id = ( ( ! empty( $_GET['wpcm_vehicle_id'] ) ) ? absint( $_GET['wpcm_vehicle_id'] ) : 0 );

		switch ( get_post_status( $listing_id ) ) {
			case 'pending' :
				echo wpautop( sprintf( __( '%s has been submitted successfully and will be visible once approved.', 'wpcm-wc-paid-listings' ), '<strong>' . get_the_title( $listing_id ) . '</strong>' ) );
				break;
			case 'wpcm_pending_payment' :
			case 'expired' :
				echo wpautop( sprintf( __( '%s has been submitted successfully and will be visible once payment has been confirmed.', 'wpcm-wc-paid-listings' ), '<strong>' . get_the_title( $listing_id ) . '</strong>' ) );
				break;
			default :
				echo wpautop( sprintf( __( '%s has been submitted successfully.', 'wpcm-wc-paid-listings' ), '<strong>' . get_the_title( $listing_id ) . '</strong>' ) );
				break;
		}

		echo '<p class="wpcm-submitted-actions">';

		if ( 'publish' === get_post_status( $listing_id ) ) {
			echo '<a class="button wpcm-button" href="' . get_permalink( $listing_id ) . '">' . __( 'View Listing', 'wpcm-wc-paid-listings' ) . '</a> ';
		} elseif ( absint( wp_car_manager()->service( 'settings' )->get_option( 'page_dashboard' ) ) > 0 ) {
			echo '<a class="button wpcm-button" href="' . get_permalink( wp_car_manager()->service( 'settings' )->get_option( 'page_dashboard' ) ) . '">' . __( 'View Dashboard', 'wpcm-wc-paid-listings' ) . '</a> ';
		}

		echo '</p>';

	}
}