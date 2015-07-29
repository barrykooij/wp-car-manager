<?php

namespace Never5\WPCarManager\MetaBox;

use Never5\WPCarManager;

class CarData extends MetaBox {

	private $fields = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->fields = array(
			'condition' => array(
				'type'    => 'select',
				'options' => array(
					'new' => 'New',
					'used'    => 'Used'
				),
				'label'   => __( 'Condition', 'wp-car-manager' ),
				'key'     => 'condition'
			),
			'make'         => array(
				'type'  => 'text',
				'label' => __( 'Make', 'wp-car-manager' ),
				'key'   => 'make'
			),
			'model'        => array(
				'type'  => 'text',
				'label' => __( 'Model', 'wp-car-manager' ),
				'key'   => 'model'
			),
			'year'         => array(
				'type'  => 'text',
				'label' => __( 'Year', 'wp-car-manager' ),
				'key'   => 'year'
			),
			'price'        => array(
				'type'  => 'text',
				'label' => __( 'Price', 'wp-car-manager' ),
				'key'   => 'price'
			),
			'mileage'      => array(
				'type'  => 'text',
				'label' => __( 'Mileage', 'wp-car-manager' ),
				'key'   => 'mileage'
			),
			'fuel_type'    => array(
				'type'  => 'text',
				'label' => __( 'Fuel Type', 'wp-car-manager' ),
				'key'   => 'fuel_type'
			),
			'color'        => array(
				'type'  => 'text',
				'label' => __( 'Color', 'wp-car-manager' ),
				'key'   => 'color'
			),
			'body_style'   => array(
				'type'  => 'text',
				'label' => __( 'Body Style', 'wp-car-manager' ),
				'key'   => 'body_style'
			),
			'transmission' => array(
				'type'    => 'select',
				'options' => array(
					'automatic' => 'Automatic',
					'manual'    => 'Manual'
				),
				'label'   => __( 'Transmission', 'wp-car-manager' ),
				'key'     => 'transmission'
			),
			'engine'       => array(
				'type'  => 'text',
				'label' => __( 'Engine', 'wp-car-manager' ),
				'key'   => 'engine'
			),
			'doors'       => array(
				'type'  => 'text',
				'label' => __( 'Doors', 'wp-car-manager' ),
				'key'   => 'doors'
			),
		);

		parent::__construct( 'car-data', __( 'Car Data', 'wp-car-manager' ), 'side' );
	}

	/**
	 * Actual meta box output
	 *
	 * @parem \WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// nonce
		$this->output_nonce();

		// add values to fields
		$fields = array();
		foreach ( $this->fields as $key => $val ) {
			$fields[ $key ] = array_merge( $val, array( 'value' => get_post_meta( $post->ID, 'wpcm_' . $val['key'], true ) ) );
		}

		// view
		wp_car_manager()->service( 'view_manager' )->display( 'mb-car-data', array(
			'mb_prefix' => 'wpcm-cd',
			'fields'    => $fields
		) );
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
			foreach ( $_POST['wpcm-cd'] as $key => $val ) {
				if ( isset( $this->fields[ $key ] ) ) {
					update_post_meta( $post->ID, 'wpcm_' . $key, $val );
				}
			}
		}

	}

}