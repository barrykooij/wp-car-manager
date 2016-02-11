<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class DeleteImage extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'delete_image' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// vehicle must be set
		if ( ! isset( $_POST['vehicle'] ) || empty( $_POST['vehicle'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// image must be set
		if ( ! isset( $_POST['image'] ) || empty( $_POST['image'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// check nonce
		$this->check_nonce();

		// sanitize variables
		$vehicle_id = absint( $_POST['vehicle'] );
		$image_id   = absint( $_POST['image'] );

		// check if user is allowed to edit this vehicle
		if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// vehicle object
		/** @var Vehicle\Vehicle $vehicle */
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $vehicle_id );

		// featured image ID
		$featured_id = get_post_thumbnail_id( $vehicle->get_id() );

		// attachment ids
		$attachment_ids = $vehicle->get_gallery_attachment_ids();

		// check if image id exists in vehicle
		if ( $featured_id != $image_id && ! in_array( $image_id, $attachment_ids ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// check if the image is the featured image
		if ( $featured_id == $image_id ) {

			// delete featured image
			delete_post_thumbnail( $vehicle->get_id() );

			// check if we have other image so we can set a new featured image
			if ( is_array( $attachment_ids ) && count( $attachment_ids ) > 0 ) {

				// first image
				$first_image = array_shift( $attachment_ids );

				// set as featured image
				set_post_thumbnail( $vehicle_id, $first_image );

				// set new array as attachment ids in vehicle object
				$vehicle->set_gallery_attachment_ids( $attachment_ids );

				// save vehicle object
				wp_car_manager()->service( 'vehicle_repository' )->persist( $vehicle );
			}

		} else if ( ( $attachment_key = array_search( $image_id, $attachment_ids ) ) !== false ) {
			// if not the image should be an attachment id but just checking to be absolutely sure

			// remove image from local array
			unset( $attachment_ids[ $attachment_key ] );

			// set new array as attachment ids in vehicle object
			$vehicle->set_gallery_attachment_ids( $attachment_ids );

			// save vehicle object
			wp_car_manager()->service( 'vehicle_repository' )->persist( $vehicle );
		}

		// done
		wp_send_json( array( 'success' => true ) );

		// bye
		exit;
	}

}