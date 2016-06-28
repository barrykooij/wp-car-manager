<?php
namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\Helper;

abstract class Vehicle {

	/** @var int */
	private $id = null;

	/** @var  String */
	private $status;

	/** @var String */
	private $title;

	/** @var int */
	private $author;

	/** @var \DateTime */
	private $expiration;

	/** @var String */
	private $description;

	/** @var string */
	private $short_description = '';

	/** @var String */
	private $condition;

	/** @var String */
	private $make;

	/** @var String */
	private $model;

	/** @var \DateTime */
	private $frdate;

	/** @var String */
	private $price;

	/** @var String */
	private $color;

	/** @var array */
	private $features = array();

	/** @var String */
	private $gallery_attachment_ids;

	/** @var int */
	private $sold;

	/**
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * @return String
	 */
	public function get_status() {
		return $this->status;
	}

	/**
	 * @param String $status
	 */
	public function set_status( $status ) {
		$this->status = $status;
	}

	/**
	 * @return String
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * @param String $title
	 */
	public function set_title( $title ) {
		$this->title = $title;
	}

	/**
	 * @return int
	 */
	public function get_author() {
		return $this->author;
	}

	/**
	 * @param int $author
	 */
	public function set_author( $author ) {
		$this->author = $author;
	}

	/**
	 * @return \DateTime
	 */
	public function get_expiration() {
		return $this->expiration;
	}

	/**
	 * @param \DateTime $expiration
	 */
	public function set_expiration( $expiration ) {
		$this->expiration = $expiration;
	}

	/**
	 * @return String
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * @param String $description
	 */
	public function set_description( $description ) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function get_short_description() {
		return $this->short_description;
	}

	/**
	 * @param string $short_description
	 */
	public function set_short_description( $short_description ) {
		$this->short_description = $short_description;
	}

	/**
	 * @return String
	 */
	public function get_condition() {
		return $this->condition;
	}

	/**
	 * @param String $condition
	 */
	public function set_condition( $condition ) {
		$this->condition = $condition;
	}

	/**
	 * Get formatted condition
	 *
	 * @return String
	 */
	public function get_formatted_condition() {
		$conditions = Data::get_conditions();
		$condition  = $this->get_condition();
		if ( isset( $conditions[ $condition ] ) ) {
			$condition = $conditions[ $condition ];
		}

		return $condition;
	}

	/**
	 * @return String
	 */
	public function get_make() {
		return $this->make;
	}

	/**
	 * Get make name
	 *
	 * @return string
	 */
	public function get_make_name() {
		$make = wp_car_manager()->service( 'make_model_manager' )->get_make( $this->get_make() );

		return $make['name'];
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
	 * Get model name
	 *
	 * @return string
	 */
	public function get_model_name() {
		$model = wp_car_manager()->service( 'make_model_manager' )->get_model( $this->get_model() );

		return $model['name'];
	}

	/**
	 * @param String $model
	 */
	public function set_model( $model ) {
		$this->model = $model;
	}

	/**
	 * @return \DateTime
	 */
	public function get_frdate() {
		return $this->frdate;
	}

	/**
	 * Returns formatted date string
	 *
	 * @return string
	 */
	public function get_formatted_frdate() {
		$frdate = $this->get_frdate();

		if ( ! empty( $frdate ) ) {
			try {
				$frdate = $this->get_frdate()->format( Helper\Date::get_date_format() );
			} catch ( \Exception $e ) {
				$frdate = '';
			}
		}

		return $frdate;
	}

	/**
	 * @param \DateTime $frdate
	 */
	public function set_frdate( $frdate ) {
		$this->frdate = $frdate;
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
	 * Returns formatted price
	 *
	 * @return String
	 */
	public function get_formatted_price() {
		return Helper\Format::price( $this->get_price() );
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

	/**
	 * @return array
	 */
	public function get_features() {
		return $this->features;
	}

	/**
	 * @param array $features
	 */
	public function set_features( $features ) {
		$this->features = $features;
	}

	/**
	 * @return String
	 */
	public function get_gallery_attachment_ids() {
		return $this->gallery_attachment_ids;
	}

	/**
	 * @param String $gallery_attachment_ids
	 */
	public function set_gallery_attachment_ids( $gallery_attachment_ids ) {
		$this->gallery_attachment_ids = $gallery_attachment_ids;
	}

	/**
	 * Get the URL (permalink) of the Vehicle
	 *
	 * @return mixed
	 */
	public function get_url() {
		return \get_permalink( $this->get_id() );
	}

	/**
	 * Get the URL to edit the vehicle
	 *
	 * @return string
	 */
	public function get_edit_url() {
		return Helper\Pages::get_page_edit( $this->get_id() );
	}

	/**
	 * @return int
	 */
	public function get_sold() {
		return $this->sold;
	}

	/**
	 * @param int $sold
	 */
	public function set_sold( $sold ) {
		$this->sold = $sold;
	}

	/**
	 * @return bool
	 */
	public function is_sold() {
		return ( '1' == $this->get_sold() );
	}

}