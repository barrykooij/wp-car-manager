<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\Taxonomies;

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

		$data->id                = $post->ID;
		$data->short_description = $post->post_excerpt;
		$data->condition         = get_post_meta( $post->ID, $pm_prefix . 'condition', true );
		$data->make              = get_post_meta( $post->ID, $pm_prefix . 'make', true );
		$data->model             = get_post_meta( $post->ID, $pm_prefix . 'model', true );
		$data->frdate            = new \DateTime( get_post_meta( $post->ID, $pm_prefix . 'frdate', true ) );
		$data->price             = get_post_meta( $post->ID, $pm_prefix . 'price', true );
		$data->color             = get_post_meta( $post->ID, $pm_prefix . 'color', true );
		$data->mileage           = get_post_meta( $post->ID, $pm_prefix . 'mileage', true );
		$data->fuel_type         = get_post_meta( $post->ID, $pm_prefix . 'fuel_type', true );
		$data->transmission      = get_post_meta( $post->ID, $pm_prefix . 'transmission', true );
		$data->engine            = get_post_meta( $post->ID, $pm_prefix . 'engine', true );
		$data->body_style        = get_post_meta( $post->ID, $pm_prefix . 'body_style', true );
		$data->doors             = get_post_meta( $post->ID, $pm_prefix . 'doors', true );
		$data->features          = wp_get_post_terms( $post->ID, Taxonomies::FEATURES, array( 'fields' => 'names' ) );

		// get product gallery
		$product_image_gallery = '';
		if ( metadata_exists( 'post', $post->ID, '_car_gallery' ) ) {
			$product_image_gallery = get_post_meta( $post->ID, '_car_gallery', true );
		}

		// set attachments ids
		$data->gallery_attachment_ids = array_filter( explode( ',', $product_image_gallery ) );

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