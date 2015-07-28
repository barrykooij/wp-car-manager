<?php

namespace Never5\WPCarManager\Vehicle;

abstract class MotorVehicle extends Vehicle {

	/** @var String */
	private $mileage;

	/** @var String */
	private $fuel_type;

	/** @var String */
	private $transmission;

	/** @var String */
	private $engine;

	/**
	 * @return String
	 */
	public function get_mileage() {
		return $this->mileage;
	}

	/**
	 * @param String $mileage
	 */
	public function set_mileage( $mileage ) {
		$this->mileage = $mileage;
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
}