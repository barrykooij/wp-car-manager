<?php

namespace Never5\WPCarManager\Admin\MetaBox;

use Never5\WPCarManager;
use Never5\WPCarManager\Vehicle;

class Gallery extends MetaBox {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'car-gallery', __( 'Car Gallery', 'wp-car-manager' ), 'side', 'low' );
	}

	/**
	 * Actual meta box output
	 *
	 * @param \WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// nonce
		$this->output_nonce();

		// get attachments
		$product_image_gallery = '';
		if ( metadata_exists( 'post', $post->ID, '_car_gallery' ) ) {
			$product_image_gallery = get_post_meta( $post->ID, '_car_gallery', true );
		}

		// explode and filter
		$attachments = array_filter( explode( ',', $product_image_gallery ) );

		// view
		wp_car_manager()->service( 'view_manager' )->display( 'meta-box/gallery', array(
			'car_gallery' => $product_image_gallery,
			'attachments' => $attachments,
		) );
	}

	/**
	 * Triggered on save_post
	 *
	 * @param int $post_id
	 * @param \WP_Post $post
	 */
	public function save_meta_box( $post_id, $post ) {

		// check if we should save
		if ( true !== $this->should_save( $post ) ) {
			return;
		}

		// save
		if ( isset( $_POST['car_gallery'] ) ) {
			// get attachment ids and clean, to array and filter them
			$attachment_ids = isset( $_POST['car_gallery'] ) ? array_filter( explode( ',', sanitize_text_field( $_POST['car_gallery'] ) ) ) : array();

			// save attachment id's as string
			update_post_meta( $post_id, '_car_gallery', implode( ',', $attachment_ids ) );
		}

	}

}