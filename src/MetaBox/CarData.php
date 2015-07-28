<?php

namespace Never5\WPCarManager\MetaBox;

use Never5\WPCarManager;

class CarData {

	/**
	 * Setup meta box
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
	}

	/**
	 * Add meta box
	 */
	public function add_meta_box() {
		// add meta box
		add_meta_box( 'wpcm-car-data', __( 'Car Data', 'wp-car-manager' ),
			array( $this, 'meta_box_output' ), WPCarManager\PostType::PT, 'normal', 'high' );
	}

	/**
	 * Actual meta box output
	 */
	public function meta_box_output() {
		wp_car_manager()->service( 'view_manager' )->display( 'mb-car-data', array() );
	}

	/**
	 * Triggered on save_post
	 *
	 * @param int $post_id
	 * @param \WP_Post $post
	 */
	public function save_meta_box( $post_id, $post ) {
		// nonce check #1
		if ( ! isset( $_POST['wpcm_car_data_nonce'] ) ) {
			return;
		}

		// nonce check #2
		if ( ! wp_verify_nonce( $_POST['wpcm_car_data_nonce'], 'datnonceHO1q2jolO5MOpVT4ufIu' ) ) {
			return;
		}

		// autosave check
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// post type check
		if ( WPCarManager\PostType::PT != $post->post_type ) {
			return;
		}

		// capabilities
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

	}

}