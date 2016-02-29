<?php

namespace Never5\WPCarManager\Ajax;

use Never5\WPCarManager\Vehicle;

class SaveImages extends Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'save_images' );
	}

	/**
	 * AJAX callback method
	 *
	 * @return void
	 */
	public function run() {

		// vehicle must be set
		if ( ! isset( $_GET['vehicle'] ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// vehicle id
		$vehicle_id = absint( $_GET['vehicle'] );

		// check if user is allowed to edit this vehicle
		if ( ! wp_car_manager()->service( 'user_manager' )->can_edit_listing( $vehicle_id ) ) {
			wp_send_json( array( 'success' => false ) );
		}

		// create vehicle object
		/** @var Vehicle\Car $vehicle */
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $vehicle_id );

		// require the wp_handle_upload containing file
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}

		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();

		// array to store gallery image id's
		$gallery_ids = array();

		// upload images to WordPress
		if ( ! empty( $_FILES['wpcm_images'] ) ) {


			// re-format files
			$files = array();
			for ( $i = 0; $i < count( $_FILES['wpcm_images']['name'] ); $i ++ ) {
				$files[] = array(
					'name'     => $_FILES['wpcm_images']['name'][ $i ],
					'type'     => $_FILES['wpcm_images']['type'][ $i ],
					'tmp_name' => $_FILES['wpcm_images']['tmp_name'][ $i ],
					'error'    => $_FILES['wpcm_images']['error'][ $i ],
					'size'     => $_FILES['wpcm_images']['size'][ $i ]
				);
			}

			// arg we need for wp_handle_upload
			$upload_overrides = array( 'test_form' => false );

			foreach ( $files as $file ) {

				// move temp file to WP location
				$movefile = wp_handle_upload( $file, $upload_overrides );

				if ( $movefile && ! isset( $movefile['error'] ) ) {

					// Check the type of file. We'll use this as the 'post_mime_type'.
					$filetype = wp_check_filetype( basename( $movefile['file'] ), null );

					// Prepare an array of post data for the attachment.
					$attachment = array(
						'guid'           => $wp_upload_dir['url'] . '/' . basename( $movefile['file'] ),
						'post_mime_type' => $filetype['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $movefile['file'] ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);

					// Insert the attachment.
					$attach_id = wp_insert_attachment( $attachment, $movefile['file'] );

					// add attachment id to $gallery_ids
					$gallery_ids[] = $attach_id;

					// Generate the metadata for the attachment, and update the database record.
					$attach_data = wp_generate_attachment_metadata( $attach_id, $movefile['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );

				} else {

					wp_send_json( array(
						'success' => false,
						'errors'  => array( array( 'id' => 0, 'msg' => $movefile['error'] ) )
					) );
				}

			}
		}


		// check if vehicle has featured image, if not set first image as featured image and remove from _car_gallery array
		if ( ! has_post_thumbnail( $vehicle_id ) ) {
			$first_image = array_shift( $gallery_ids );
			set_post_thumbnail( $vehicle_id, $first_image );
		}

		// set post meta _car_gallery with uploaded images
		if ( count( $gallery_ids ) > 0 ) {
			update_post_meta( $vehicle_id, '_car_gallery', implode( ',', array_merge( $vehicle->get_gallery_attachment_ids(), $gallery_ids ) ) );
		}
		
		// done
		wp_send_json( array( 'success' => true ) );

		// bye
		exit;
	}

}