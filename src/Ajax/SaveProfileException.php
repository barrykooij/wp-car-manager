<?php

namespace Never5\WPCarManager\Ajax;

class SaveProfileException extends \Exception {

	/** @var string The SaveProfileException ID */
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