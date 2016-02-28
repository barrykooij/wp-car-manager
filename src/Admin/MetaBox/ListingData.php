<?php

namespace Never5\WPCarManager\Admin\MetaBox;

use Never5\WPCarManager;
use Never5\WPCarManager\Vehicle;

class ListingData extends MetaBox {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'listing-data', __( 'Listing Data', 'wp-car-manager' ), 'side', 'default' );
	}

	/**
	 * Actual meta box output
	 *
	 * @param \WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// nonce
		$this->output_nonce();

		// vehicle
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $post->ID );

		// load view
		wp_car_manager()->service( 'view_manager' )->display( 'meta-box/mb-data', array(
			'mb_prefix' => 'wpcm-ld',
			'vehicle'   => $vehicle,
			'fields'    => array(
				'condition' => array(
					'type'     => 'date',
					'label'    => __( 'Expiry Date:', 'wp-car-manager' ),
					'key'      => 'expiration',
					'required' => false
				),
				'sold'      => array(
					'type'     => 'checkbox',
					'label'    => __( 'Sold?', 'wp-car-manager' ),
					'key'      => 'sold',
					'required' => false
				),
			)
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
		if ( isset( $_POST['wpcm-ld'] ) && count( $_POST['wpcm-ld'] ) > 0 ) {
			foreach ( $_POST['wpcm-ld'] as $key => $val ) {
				update_post_meta( $post->ID, 'wpcm_' . $key, $val );
			}

			// set sold to 0 if not set (checkbox)
			if ( ! isset( $_POST['wpcm-ld']['sold'] ) ) {
				update_post_meta( $post->ID, 'wpcm_sold', '0' );
			}

		}

	}

}