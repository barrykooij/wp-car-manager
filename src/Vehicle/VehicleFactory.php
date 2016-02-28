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

		// absint
		$id = absint( $id );

		// for now type is always car
		$type = ucfirst( 'car' );

		// vehicle
		$vehicle = null;

		// class
		$class = '\\Never5\WPCarManager\\Vehicle\\' . $type;

		// check if class exists
		if ( class_exists( $class ) ) {

			// create vehicle type
			/** @var Car $vehicle */
			$vehicle = new $class;

			if ( $id > 0 ) {

				// get data from repository
				$data = $this->repository->retrieve( $id );

				foreach ( $data as $dkey => $dval ) {
					$method = 'set_' . $dkey;
					if ( method_exists( $vehicle, $method ) ) {
						$vehicle->$method( $dval );
					}
				}

				// set props
				$vehicle->set_id( $data->id );

			} else {
				$vehicle->set_id( 0 );
			}

		}

		return $vehicle;
	}
}