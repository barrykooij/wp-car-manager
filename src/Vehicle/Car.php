<?php

namespace Never5\WPCarManager\Vehicle;

class Car extends MotorVehicle {

	/** @var String */
	private $body_style;

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

}