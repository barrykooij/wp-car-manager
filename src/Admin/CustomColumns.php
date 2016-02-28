<?php

namespace Never5\WPCarManager\Admin;

class CustomColumns {

	/**
	 * Setup custom columns
	 */
	public function setup() {

		// add custom columns
		add_filter( 'manage_edit-wpcm_vehicle_columns', array( $this, 'add_columns' ) );

		// custom column data callback
		add_action( 'manage_wpcm_vehicle_posts_custom_column', array( $this, 'column_data' ), 2 );

	}

	/**
	 * Add columns
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_columns( $columns ) {

		// must be an array
		if ( ! is_array( $columns ) ) {
			$columns = array();
		}

		// temp title
		$title = $columns['title'];

		// unset columns
		unset( $columns['taxonomy-wpcm_make_model'] );
		unset( $columns['taxonomy-wpcm_features'] );
		unset( $columns['author'] );
		unset( $columns['date'] );
		unset( $columns['title'] );

		// add new columns
		$columns['image']   = '<span class="wpcm-admin-image-header"></span>';
		$columns['title']   = $title;
		$columns['make']    = __( 'Make', 'wp-car-manager' );
		$columns['model']   = __( 'Model', 'wp-car-manager' );
		$columns['price']   = __( 'Price', 'wp-car-manager' );
		$columns['mileage'] = __( 'Mileage', 'wp-car-manager' );
		$columns['frdate']  = __( 'FR Date', 'wp-car-manager' );
		$columns['expires'] = __( 'Expires', 'wp-car-manager' );
		$columns['actions'] = __( 'Actions', 'wp-car-manager' );

		return $columns;
	}

	/**
	 * Custom column data
	 *
	 * @param string $column
	 */
	public function column_data( $column ) {
		global $post;

		/** @var \Never5\WPCarManager\Vehicle\Vehicle $vehicle */
		$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $post->ID );

		// val
		$val = '';

		// set correct column val
		switch ( $column ) {
			case 'image':

				// title
				$title = get_the_title( $vehicle->get_id() );

				// check if there's a thumbnail
				if ( has_post_thumbnail( $vehicle->get_id() ) ) {

					// get image
					$val = get_the_post_thumbnail( $vehicle->get_id(), apply_filters( 'wpcm_listings_vehicle_thumbnail_size', 'wpcm_vehicle_listings_item' ), array(
						'title' => $title,
						'alt'   => $title,
						'class' => 'wpcm-admin-image'
					) );

				} else {
					$placeholder = apply_filters( 'wpcm_listings_vehicle_thumbnail_placeholder', wp_car_manager()->service( 'file' )->image_url( 'placeholder-list.png' ), $vehicle );
					$val         = sprintf( '<img src="%s" alt="%s" class="wpcm-admin-image" />', $placeholder, __( 'Placeholder', 'wp-car-manager' ) );
				}

				$val = '<a href="' . admin_url( sprintf( 'post.php?post=%d&action=edit', $post->ID ) ) . '">' . $val . '</a>';

				break;
			case 'make' :
				$val = $vehicle->get_make_name();
				break;
			case 'model' :
				$val = $vehicle->get_model_name();
				break;
			case 'price' :
				$val = $vehicle->get_formatted_price();
				break;
			case 'mileage' :
				$val = $vehicle->get_formatted_mileage();
				break;
			case 'frdate' :
				$val = $vehicle->get_formatted_frdate();
				break;
			case 'expires' :
				$expiration = $vehicle->get_expiration();
				if ( null != $expiration ) {
					$val = $expiration->format( str_ireplace( 'F', 'M', get_option( 'date_format' ) ) );
				}
				break;
			case 'actions':
				if ( 'pending' == $vehicle->get_status() ) {
					$val = '<a href="' . add_query_arg( array(
							'wpcm_action'     => 'approve',
							'wpcm_action_val' => $post->ID,
							'wpcm_nonce'      => wp_create_nonce( 'wpcm_action_approve_' . $post->ID )
						), admin_url( 'edit.php?post_type=wpcm_vehicle' ) ) . '" class="button wpcm-btn-approve"></a>';
				}
				break;
		}

		// if val is empty set to -
		if ( '' == $val ) {
			$val = '-';
		}

		// echo val
		echo $val;
	}


}