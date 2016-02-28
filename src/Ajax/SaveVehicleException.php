<?php

namespace Never5\WPCarManager\Ajax;

class SaveVehicleException extends \Exception {

	/** @var string The SaveVehicleException ID */
	protected $id;

	public function __construct( $message, $id ) {
		$this->id = $id;
		parent::__construct( $message );
	}

	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

}