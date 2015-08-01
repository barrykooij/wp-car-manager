<?php

namespace Never5\WPCarManager\Admin\Page;

use Never5\WPCarManager\Taxonomies;

class Makes {

	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Makes & Models', 'wp-car-manager' ), __( 'Makes & Models', 'wp-car-manager' ), 'manage_options', 'wpcm-makes', array(
			$this,
			'output'
		) );
	}

	public function output() {

		$items = array();

		$terms = get_terms( Taxonomies::MAKE_MODEL, array(
			'hide_empty'   => false,
			'hierarchical' => false,
		) );

		if ( count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {
				$items[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug
				);
			}
		}
		// load view
		wp_car_manager()->service( 'view_manager' )->display( 'page/makes-models', array(
			'title' => __( 'Makes', 'wp-car-manager' ),
			'items' => $items,
		) );
	}

}