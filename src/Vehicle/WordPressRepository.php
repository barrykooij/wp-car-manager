<?php

namespace Never5\WPCarManager\Vehicle;

class WordPressRepository implements VehicleRepository {

	/**
	 * @param int $id
	 *
	 * @throws \Exception
	 *
	 * @return \stdClass();
	 */
	public function retrieve( $id ) {
		$post = get_post( $id );
		if ( null === $post ) {
			throw new \Exception( 'Vehicle not found' );
		}

		$data = new \stdClass();

		$pm_prefix = 'wpcm_';

		$data->id           = $post->ID;
		$data->condition    = get_post_meta( $post->ID, $pm_prefix . 'condition', true );
		$data->make         = get_post_meta( $post->ID, $pm_prefix . 'make', true );
		$data->model        = get_post_meta( $post->ID, $pm_prefix . 'model', true );
		$data->year         = get_post_meta( $post->ID, $pm_prefix . 'year', true );
		$data->price        = get_post_meta( $post->ID, $pm_prefix . 'price', true );
		$data->color        = get_post_meta( $post->ID, $pm_prefix . 'color', true );
		$data->mileage      = get_post_meta( $post->ID, $pm_prefix . 'mileage', true );
		$data->fuel_type    = get_post_meta( $post->ID, $pm_prefix . 'fuel_type', true );
		$data->transmission = get_post_meta( $post->ID, $pm_prefix . 'engine', true );
		$data->engine       = get_post_meta( $post->ID, $pm_prefix . 'transmission', true );
		$data->body_style   = get_post_meta( $post->ID, $pm_prefix . 'body_style', true );
		$data->doors        = get_post_meta( $post->ID, $pm_prefix . 'doors', true );

		return $data;

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