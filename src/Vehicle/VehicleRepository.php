<?php

namespace Never5\WPCarManager\Vehicle;

interface VehicleRepository {

	/**
	 * @param int $id
	 *
	 * @return \stdClass
	 */
	public function retrieve( $id );

	/**
	 * @param Vehicle $vehicle
	 *
	 * @return bool
	 */
	public function persist( $vehicle );
}