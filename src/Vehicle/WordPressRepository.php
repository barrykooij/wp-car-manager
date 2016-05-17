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
		$data->status            = $post->post_status;
		$data->title             = $post->post_title;
		$data->author            = $post->post_author;
		$data->expiration        = ( ( false != get_post_meta( $post->ID, $pm_prefix . 'expiration', true ) ) ? new \DateTime( get_post_meta( $post->ID, $pm_prefix . 'expiration', true ) ) : null );
		$data->description       = $post->post_content; // @todo check if we need to apply filters here
		$data->short_description = wp_trim_words( ( ! empty( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content ), absint( apply_filters( 'wpcm_vehicle_short_description_length', 30 ) ) );
		$data->condition         = get_post_meta( $post->ID, $pm_prefix . 'condition', true );
		$data->make              = get_post_meta( $post->ID, $pm_prefix . 'make', true );
		$data->model             = get_post_meta( $post->ID, $pm_prefix . 'model', true );
		$data->price        = get_post_meta( $post->ID, $pm_prefix . 'price', true );
		$data->color        = get_post_meta( $post->ID, $pm_prefix . 'color', true );
		$data->mileage      = get_post_meta( $post->ID, $pm_prefix . 'mileage', true );
		$data->fuel_type    = get_post_meta( $post->ID, $pm_prefix . 'fuel_type', true );
		$data->transmission = get_post_meta( $post->ID, $pm_prefix . 'transmission', true );
		$data->engine       = get_post_meta( $post->ID, $pm_prefix . 'engine', true );
		$data->power_hp     = get_post_meta( $post->ID, $pm_prefix . 'power_hp', true );
		$data->power_kw     = get_post_meta( $post->ID, $pm_prefix . 'power_kw', true );
		$data->body_style   = get_post_meta( $post->ID, $pm_prefix . 'body_style', true );
		$data->doors        = get_post_meta( $post->ID, $pm_prefix . 'doors', true );
		$data->sold         = get_post_meta( $post->ID, $pm_prefix . 'sold', true );

		// wrap frdate in try-catch in case someone enters an incorrect date
		try {
			$data->frdate = new \DateTime( get_post_meta( $post->ID, $pm_prefix . 'frdate', true ) );
		} catch ( \Exception $e ) {
			$data->frdate = '';
		}

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
	 * Persist Vehicle in WordPress database
	 *
	 * @param Car $vehicle
	 *
	 * @throws \Exception
	 *
	 * @return Vehicle $vehicle
	 */
	public function persist( $vehicle ) {

		// check if new or existing
		if ( 0 == $vehicle->get_id() ) {

			// create
			$vehicle_id = wp_insert_post( array(
				'post_title'   => $vehicle->get_title(),
				'post_content' => $vehicle->get_description(),
				'post_excerpt' => $vehicle->get_short_description(),
				'post_author'  => $vehicle->get_author(),
				'post_type'    => PostType::VEHICLE,
				'post_status'  => $vehicle->get_status()
			) );

			if ( is_wp_error( $vehicle_id ) ) {
				throw new \Exception( 'Unable to insert post in WordPress database' );
			}

			// set new vehicle ID
			$vehicle->set_id( $vehicle_id );

		} else {

			// update
			$vehicle_id = wp_update_post( array(
				'ID'           => $vehicle->get_id(),
				'post_title'   => $vehicle->get_title(),
				'post_content' => $vehicle->get_description(),
				'post_excerpt' => $vehicle->get_short_description(),
				'post_status'  => $vehicle->get_status()
			) );

			if ( is_wp_error( $vehicle_id ) ) {
				throw new \Exception( 'Unable to updarte post in WordPress database' );
			}

		}

		// get fields
		$fields = Data::get_fields();

		// set expiration date
		if ( null != $vehicle->get_expiration() ) {
			update_post_meta( $vehicle->get_id(), 'wpcm_expiration', $vehicle->get_expiration()->format( 'Y-m-d' ) );
		} else {
			delete_post_meta( $vehicle->get_id(), 'wpcm_expiration' );
		}

		// set sold
		update_post_meta( $vehicle->get_id(), 'wpcm_sold', $vehicle->get_sold() );

		// set vehicle meta-data
		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field_key => $field ) {

				// the method
				$method = 'get_' . $field_key;

				// check if exists in vehicle
				if ( method_exists( $vehicle, $method ) ) {

					// the value
					$value = $vehicle->$method();

					// turn \DateTime object into formatted string
					if ( $value instanceof \DateTime ) {
						$value = $value->format( 'Y-m-d' );
					}

					// update post method
					update_post_meta( $vehicle->get_id(), 'wpcm_' . $field_key, $value );
				}

			}
		}

		// set vehicle features
		$obj_features = $vehicle->get_features();
		if ( ! empty( $obj_features ) ) {

			// store feature ID's in array
			$terms = array();
			foreach ( $vehicle->get_features() as $feature_id => $feature ) {
				$terms[] = $feature_id;
			}

			// set object terms
			wp_set_object_terms( $vehicle->get_id(), $terms, Taxonomies::FEATURES );

			// re-fetch features from DB so we're sure to have a correctly formatted array
			$vehicle->set_features( $this->get_formatted_features( $vehicle->get_id() ) );
		}

		// set images
		if ( is_array( $vehicle->get_gallery_attachment_ids() ) && count( $vehicle->get_gallery_attachment_ids() ) > 0 ) {
			update_post_meta( $vehicle_id, '_car_gallery', implode( ',', $vehicle->get_gallery_attachment_ids() ) );
		} else {
			update_post_meta( $vehicle_id, '_car_gallery', '' );
		}

		return $vehicle;
	}

}