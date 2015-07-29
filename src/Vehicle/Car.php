<?php

namespace Never5\WPCarManager\Vehicle;

class Car extends MotorVehicle {

	/** @var String */
	private $body_style;

	/** @var int */
	private $doors;

	/**
	 * @return String
	 */
	public function get_body_style() {
		return $this->body_style;
	}

	/**
	 * @param String $body_style
	 */
	public function set_body_style( $body_style ) {
		$this->body_style = $body_style;
	}

	/**
	 * @return int
	 */
	public function get_doors() {
		return $this->doors;
	}

	/**
	 * @param int $doors
	 */
	public function set_doors( $doors ) {
		$this->doors = $doors;
	}

}