<?php

namespace Never5\WPCarManager\Vehicle;

class Data {

	/**
	 * Get Vehicle fields
	 *
	 * @param string $type Not used at the moment, but will be used when more than 1 vehicle type is offered
	 *
	 * @return array
	 */
	public static function get_fields( $type = 'car' ) {

		return array(
			'condition'    => array(
				'type'    => 'select',
				'options' => self::get_conditions(),
				'label'   => __( 'Condition', 'wp-car-manager' ),
				'key'     => 'condition'
			),
			'make'         => array(
				'type'    => 'select',
				'options' => wp_car_manager()->service('make_model_manager')->get_makes_map(),
				'label'   => __( 'Make', 'wp-car-manager' ),
				'key'     => 'make'
			),
			'model'        => array(
				'type'  => 'select-model',
				'label' => __( 'Model', 'wp-car-manager' ),
				'key'   => 'model'
			),
			'frdate'         => array(
				'type'  => 'text',
				'label' => __( 'First Registration Date', 'wp-car-manager' ),
				'key'   => 'frdate'
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
				'options' => self::get_transmissions(),
				'label'   => __( 'Transmission', 'wp-car-manager' ),
				'key'     => 'transmission'
			),
			'engine'       => array(
				'type'  => 'text',
				'label' => __( 'Engine', 'wp-car-manager' ),
				'key'   => 'engine'
			),
			'doors'        => array(
				'type'  => 'text',
				'label' => __( 'Doors', 'wp-car-manager' ),
				'key'   => 'doors'
			),
		);
	}

	/**
	 * Return condition possibilities
	 *
	 * @return array
	 */
	public static function get_conditions() {
		return array(
			'new'  => __( 'New', 'wp-car-manager' ),
			'used' => __( 'Used', 'wp-car-manager' )
		);
	}

	/**
	 * Get transmission possibilities
	 *
	 * @return array
	 */
	public static function get_transmissions() {
		return array(
			'automatic' => __( 'Automatic', 'wp-car-manager' ),
			'manual'    => __( 'Manual', 'wp-car-manager' )
		);
	}

}