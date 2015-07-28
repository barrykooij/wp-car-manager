<?php

namespace Never5\WPCarManager\Vehicle;

class WordPressRepository implements VehicleRepository {

	/**
	 * @param int $id
	 *
	 * @throws \Exception
	 *
	 * @return Vehicle
	 */
	public function retrieve( $id ) {
		$post = get_post( $id );
		if ( null === $post ) {
			throw new \Exception( 'Vehicle not found' );
		}

		// for now type is always car
		$type = ucfirst( 'car' );

		if ( class_exists( '\\Never5\WPCarManager\Vehicle' . $type ) ) {
			$vehicle = new $type;

			print_r( $vehicle );
		}
	}

	/**
	 * @param Vehicle $vehicle
	 *
	 * @return bool
	 */
	public function persist( $vehicle ) {
		// TODO: Implement persist() method.
	}

}