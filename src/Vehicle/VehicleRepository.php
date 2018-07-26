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
	 * Returns number of rows for given filters
	 *
	 * @param array $filters
	 *
	 * @return int
	 */
	public function num_rows( $filters=array() );

	/**
	 * @param Vehicle $vehicle
	 *
	 * @return bool
	 */
	public function persist( $vehicle );
}