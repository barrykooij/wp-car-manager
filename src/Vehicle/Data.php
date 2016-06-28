<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\Helper;

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
				'type'     => 'select',
				'options'  => self::get_conditions(),
				'label'    => __( 'Condition', 'wp-car-manager' ),
				'key'      => 'condition',
				'required' => true,
			),
			'make'         => array(
				'type'     => 'select',
				'options'  => wp_car_manager()->service( 'make_model_manager' )->get_makes_map(),
				'label'    => __( 'Make', 'wp-car-manager' ),
				'key'      => 'make',
				'required' => true
			),
			'model'        => array(
				'type'     => 'select-model',
				'label'    => __( 'Model', 'wp-car-manager' ),
				'key'      => 'model',
				'required' => true,
			),
			'frdate'       => array(
				'type'        => 'date',
				'label'       => __( 'First Registration Date', 'wp-car-manager' ),
				'key'         => 'frdate',
				'required'    => true,
				'placeholder' => 'YY-MM-DD'
			),
			'price'        => array(
				'type'        => 'text',
				'label'       => __( 'Price', 'wp-car-manager' ),
				'key'         => 'price',
				'required'    => false,
				'placeholder' => Helper\Format::price( '29000.99', array( 'plain' => true, 'decimals' => 2 ) )
			),
			'mileage'      => array(
				'type'        => 'text',
				'label'       => __( 'Mileage', 'wp-car-manager' ),
				'key'         => 'mileage',
				'required'    => false,
				'placeholder' => Helper\Format::mileage( '100000' )
			),
			'fuel_type'    => array(
				'type'        => 'text',
				'label'       => __( 'Fuel Type', 'wp-car-manager' ),
				'key'         => 'fuel_type',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( 'Gas', 'wp-car-manager' )
			),
			'color'        => array(
				'type'        => 'text',
				'label'       => __( 'Color', 'wp-car-manager' ),
				'key'         => 'color',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( 'Grey', 'wp-car-manager' )
			),
			'body_style'   => array(
				'type'        => 'text',
				'label'       => __( 'Body Style', 'wp-car-manager' ),
				'key'         => 'body_style',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( 'Sedan', 'wp-car-manager' )
			),
			'transmission' => array(
				'type'     => 'select',
				'options'  => self::get_transmissions(),
				'label'    => __( 'Transmission', 'wp-car-manager' ),
				'key'      => 'transmission',
				'required' => false,
			),
			'doors'        => array(
				'type'        => 'text',
				'label'       => __( 'Doors', 'wp-car-manager' ),
				'key'         => 'doors',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' 5'
			),
			'engine'       => array(
				'type'        => 'text',
				'label'       => __( 'Engine', 'wp-car-manager' ),
				'key'         => 'engine',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( '2.0 TDI', 'wp-car-manager' )
			),
			'power_kw'        => array(
				'type'        => 'text',
				'label'       => __( 'Power kW', 'wp-car-manager' ),
				'key'         => 'power_kw',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( '125', 'wp-car-manager' )
			),
			'power_hp'        => array(
				'type'        => 'text',
				'label'       => __( 'Power hp', 'wp-car-manager' ),
				'key'         => 'power_hp',
				'required'    => false,
				'placeholder' => __( 'e.g.', 'wp-car-manager' ) . ' ' . __( '170', 'wp-car-manager' )
			),
		);
	}

	/**
	 * Return condition possibilities
	 *
	 * @return array
	 */
	public static function get_conditions() {
		return apply_filters( 'wpcm_conditions', array(
			'new'  => __( 'New', 'wp-car-manager' ),
			'used' => __( 'Used', 'wp-car-manager' )
		) );
	}

	/**
	 * Get transmission possibilities
	 *
	 * @return array
	 */
	public static function get_transmissions() {
		return apply_filters( 'wpcm_transmissions', array(
			'automatic'      => __( 'Automatic', 'wp-car-manager' ),
			'manual'         => __( 'Manual', 'wp-car-manager' ),
			'semi-automatic' => __( 'Semi-Automatic', 'wp-car-manager' )
		) );
	}

	/**
	 * Remove fields that have no value data
	 *
	 * @param array $fields
	 * @param Vehicle $vehicle
	 *
	 * @return array
	 */
	public static function remove_empty_fields( $fields, $vehicle ) {

		foreach ( $fields as $field_key => $field ) {
			$data_method = 'get_' . $field;
			if ( method_exists( $vehicle, $data_method ) ) {
				$data_val = $vehicle->$data_method();
				if ( '' == $data_val ) {
					unset( $fields[ $field_key ] );
				}
			}
		}

		return $fields;
	}
}
