<?php

namespace Never5\WPCarManager\Vehicle;

class VehicleFactory {

	/** @var VehicleRepository $repository */
	private $repository;

	/**
	 * @param VehicleRepository $repository
	 */
	public function __construct( VehicleRepository $repository ) {
		$this->repository = $repository;
	}

	/**
	 * Create Vehicle
	 *
	 * @param int $id
	 *
	 * @return Vehicle
	 */
	public function make( $id = 0 ) {
		return $this->repository->retrieve( $id );
	}
}