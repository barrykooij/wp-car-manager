<?php

namespace Never5\WPCarManager\Admin\MetaBox;

use Never5\WPCarManager;
use Never5\WPCarManager\Vehicle;

class CarData extends MetaBox {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'car-data', __( 'Car Data', 'wp-car-manager' ), 'normal', 'high' );

		// Add AJAX endpoint
		add_action( 'wp_ajax_wpcm_admin_get_models', array( $this, 'ajax_get_models' ) );
	}

	/**
	 * Actual meta box output
	 *
	 * @param \WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// nonce
		$this->output_nonce();

		// vehicle
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $post->ID );

		// get fields
		$fields = Vehicle\Data::get_fields();

		// split fields into 2 arrays
		$tables = array_chunk( $fields, ( ceil( count( $fields ) / 2 ) ) );

		// AJAX NONCE
		wp_nonce_field( 'wpcm-dat-ajax-nonce', 'wpcm-ajax-nonce' );

		if ( count( $tables ) > 0 ) {
			foreach ( $tables as $table ) {
				// view
				wp_car_manager()->service( 'view_manager' )->display( 'meta-box/mb-data', array(
					'mb_prefix' => 'wpcm-cd',
					'fields'    => $table,
					'vehicle'   => $vehicle
				) );
			}
		}


	}

	/**
	 * Triggered on save_post
	 *
	 * @param int $post_id
	 * @param \WP_Post $post
	 */
	public function save_meta_box( $post_id, $post ) {

		// check if we should save
		if ( true !== $this->should_save( $post ) ) {
			return;
		}

		// save
		if ( isset( $_POST['wpcm-cd'] ) && count( $_POST['wpcm-cd'] ) > 0 ) {
			$fields = Vehicle\Data::get_fields();
			foreach ( $_POST['wpcm-cd'] as $key => $val ) {
				if ( isset( $fields[ $key ] ) ) {
					update_post_meta( $post->ID, 'wpcm_' . $key, $val );
				}
			}
		}

	}

	/**
	 * AJAX 'get_models' callback
	 */
	public function ajax_get_models() {

		// check nonce
		check_ajax_referer( 'wpcm-dat-ajax-nonce', 'nonce' );

		// check if make is set
		if ( ! isset( $_POST['make'] ) ) {
			return;
		}

		// make
		$make = absint( $_POST['make'] );

		// models array
		$models = array();

		// get raw models
		$models_raw = wp_car_manager()->service( 'make_model_manager' )->get_models( $make );

		// check & loop
		if ( count( $models_raw ) > 0 ) {
			foreach ( $models_raw as $model_raw ) {

				// add to $models array
				$models[] = array( 'id' => $model_raw['id'], 'name' => $model_raw['name'] );
			}
		}

		// send JSON
		wp_send_json( $models );

		// bye
		exit;
	}

}