<?php

namespace Never5\WPCarManager\MetaBox;

use Never5\WPCarManager;
use Never5\WPCarManager\Vehicle;

class CarData extends MetaBox {

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct( 'car-data', __( 'Car Data', 'wp-car-manager' ), 'side' );
	}

	/**
	 * Actual meta box output
	 *
	 * @parem \WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// nonce
		$this->output_nonce();

		// add values to fields
//		$fields = Vehicle\Data::get_fields();
//		foreach ( $fields as $key => $val ) {
//			$fields[ $key ] = array_merge( $val, array( 'value' => get_post_meta( $post->ID, 'wpcm_' . $val['key'], true ) ) );
//		}

		// view
		wp_car_manager()->service( 'view_manager' )->display( 'mb-car-data', array(
			'mb_prefix' => 'wpcm-cd',
			'fields'    => Vehicle\Data::get_fields(),
			'vehicle'   => wp_car_manager()->service( 'vehicle_factory' )->make( $post->ID )
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
		if ( isset( $_POST['wpcm-cd'] ) && count( $_POST['wpcm-cd'] ) > 0 ) {
			$fields = Vehicle\Data::get_fields();
			foreach ( $_POST['wpcm-cd'] as $key => $val ) {
				if ( isset( $fields[ $key ] ) ) {
					update_post_meta( $post->ID, 'wpcm_' . $key, $val );
				}
			}
		}

	}

}