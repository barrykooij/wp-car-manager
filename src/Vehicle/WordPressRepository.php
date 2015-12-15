<?php

namespace Never5\WPCarManager\Vehicle;

use Never5\WPCarManager\Taxonomies;

class WordPressRepository implements VehicleRepository {

	/**
	 * Get a correctly formatted features list
	 *
	 * @param int $id
	 *
	 * @return array
	 */
	private function get_formatted_features( $id ) {
		$features     = array();
		$raw_features = wp_get_post_terms( $id, Taxonomies::FEATURES, array( 'fields' => 'all' ) );
		if ( count( $raw_features ) > 0 ) {
			foreach ( $raw_features as $raw_feature ) {
				$features[ $raw_feature->term_id ] = $raw_feature->name;
			}
		}

		return $features;
	}

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
		$data->title             = $post->post_title;
		$data->author            = $post->post_author;
		$data->description       = $post->post_content; // @todo check if we need to apply filters here
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

		// get and format features
		$data->features = $this->get_formatted_features( $post->ID );

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