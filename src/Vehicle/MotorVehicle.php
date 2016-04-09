<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\Helper;

abstract class MotorVehicle extends Vehicle {

	/** @var int */
	private $mileage;

	/** @var String */
	private $fuel_type;

	/** @var String */
	private $transmission;

	/** @var String */
	private $engine;

	/** @var  int */
	private $power;

	/** @var String */
	private $power_type;

	/**
	 * @return int
	 */
	public function get_mileage() {
		return $this->mileage;
	}

	/**
	 * @param int $mileage
	 */
	public function set_mileage( $mileage ) {
		$this->mileage = $mileage;
	}

	/**
	 * Return formatted mileage
	 *
	 * @return string
	 */
	public function get_formatted_mileage() {
		return Helper\Format::mileage( $this->get_mileage() );
	}

	/**
	 * @return String
	 */
	public function get_fuel_type() {
		return $this->fuel_type;
	}

	/**
	 * @param String $fuel_type
	 */
	public function set_fuel_type( $fuel_type ) {
		$this->fuel_type = $fuel_type;
	}

	/**
	 * @return String
	 */
	public function get_transmission() {
		return $this->transmission;
	}

	/**
	 * @param String $transmission
	 */
	public function set_transmission( $transmission ) {
		$this->transmission = $transmission;
	}

	/**
	 * Get formatted transmission
	 *
	 * @return String
	 */
	public function get_formatted_transmission() {
		$transmissions = Data::get_transmissions();
		$transmission  = $this->get_transmission();
		if ( isset( $transmissions[ $transmission ] ) ) {
			$transmission = $transmissions[ $transmission ];
		}

		return $transmission;
	}

	/**
	 * @return String
	 */
	public function get_engine() {
		return $this->engine;
	}

	/**
	 * @param String $engine
	 */
	public function set_engine( $engine ) {
		$this->engine = $engine;
	}

	/**
	 * @return int
	 */
	public function get_power() {
		return $this->power;
	}

	/**
	 * @param int $power
	 */
	public function set_power( $power ) {
		$this->power = $power;
	}

	/**
	 * @return String
	 */
	public function get_power_type() {
		return $this->power_type;
	}

	/**
	 * Get the formatted power type
	 *
	 * @return String
	 */
	public function get_formatted_power_type() {
		$power_types = Data::get_power_types();
		$power_type  = $this->get_power_type();
		if ( isset( $power_types[ $power_type ] ) ) {
			$power_type = $power_types[ $power_type ];
		}

		return $power_type;
	}

	/**
	 * @param String $power_type
	 */
	public function set_power_type( $power_type ) {
		$this->power_type = $power_type;
	}
}