<?php
namespace Never5\WPCarManager\Vehicle;

abstract class Vehicle {

	/** @var String */
	private $make;

	/** @var String */
	private $model;

	/** @var String */
	private $year;

	/** @var String */
	private $price;

	/** @var String */
	private $color;

	/**
	 * @return String
	 */
	public function get_make() {
		return $this->make;
	}

	/**
	 * @param String $make
	 */
	public function set_make( $make ) {
		$this->make = $make;
	}

	/**
	 * @return String
	 */
	public function get_model() {
		return $this->model;
	}

	/**
	 * @param String $model
	 */
	public function set_model( $model ) {
		$this->model = $model;
	}

	/**
	 * @return String
	 */
	public function get_year() {
		return $this->year;
	}

	/**
	 * @param String $year
	 */
	public function set_year( $year ) {
		$this->year = $year;
	}

	/**
	 * @return String
	 */
	public function get_price() {
		return $this->price;
	}

	/**
	 * @param String $price
	 */
	public function set_price( $price ) {
		$this->price = $price;
	}

	/**
	 * @return String
	 */
	public function get_color() {
		return $this->color;
	}

	/**
	 * @param String $color
	 */
	public function set_color( $color ) {
		$this->color = $color;
	}

}