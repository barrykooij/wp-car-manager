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
	 *
	 * @parem \WP_Post $post
	 */
	public function meta_box_output( $post ) {
		wp_car_manager()->service( 'view_manager' )->display( 'mb-car-data', array(
			'fields' => array(
				array(
					'type'  => 'text',
					'label' => __( 'Make', 'wp-car-manager' ),
					'key'   => 'make',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_make', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Model', 'wp-car-manager' ),
					'key'   => 'model',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_model', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Year', 'wp-car-manager' ),
					'key'   => 'year',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_year', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Price', 'wp-car-manager' ),
					'key'   => 'price',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_price', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Mileage', 'wp-car-manager' ),
					'key'   => 'mileage',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_mileage', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Fuel Type', 'wp-car-manager' ),
					'key'   => 'fuel_type',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_fuel_type', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Color', 'wp-car-manager' ),
					'key'   => 'color',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_color', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Body Style', 'wp-car-manager' ),
					'key'   => 'body_style',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_body_style', true )
				),
				array(
					'type'  => 'select',
					'options' => array(
						'automatic' => 'Automatic',
						'manual' => 'Manual'
					),
					'label' => __( 'Transmission', 'wp-car-manager' ),
					'key'   => 'transmission',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_transmission', true )
				),
				array(
					'type'  => 'text',
					'label' => __( 'Engine', 'wp-car-manager' ),
					'key'   => 'engine',
					'value' => get_post_meta( $post->ID, 'wpcm_cd_engine', true )
				),
			)
		) );
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