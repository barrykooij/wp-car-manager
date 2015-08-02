<?php

namespace Never5\WPCarManager\Admin\Page;

use Never5\WPCarManager\Taxonomies;

class Makes {

	/**
	 * Init page
	 */
	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Makes & Models', 'wp-car-manager' ), __( 'Makes & Models', 'wp-car-manager' ), 'manage_options', 'wpcm-makes', array(
			$this,
			'page_cb'
		) );
	}

	/**
	 * Handle the post
	 */
	private function handle_post() {
		if ( isset( $_POST['wpcm_action'] ) ) {
			switch ( $_POST['wpcm_action'] ) {

				case 'edit_make':

					// term id
					$term_id = absint( $_POST['term_id'] );

					// args
					$args = array(
						'name' => $_POST['name'],
						'slug' => $_POST['slug']
					);

					// update
					wp_update_term( $term_id, Taxonomies::MAKE_MODEL, array(
						'name' => $args['name'],
						'slug' => $args['slug']
					) );
					break;
				case 'add_make':

					// add term
					wp_insert_term(
						$_POST['name'],
						Taxonomies::MAKE_MODEL,
						array(
							'slug' => $_POST['slug']
						)
					);

					break;
			}

		}
	}

	/**
	 * Load the correct view
	 */
	private function load_view() {
		// check if we're editing a page
		if ( isset( $_GET['edit'] ) ) {

			$term = get_term( absint( $_GET['edit'] ), 'wpcm_make_model' );

			// load view
			wp_car_manager()->service( 'view_manager' )->display( 'page/edit-make-model', array(
				'title' => __( 'Edit Make', 'wp-car-manager' ),
				'item'  => array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug
				),
			) );

		} else {
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
			wp_car_manager()->service( 'view_manager' )->display( 'page/makes', array(
				'title' => __( 'Makes', 'wp-car-manager' ),
				'items' => $items,
			) );
		}
	}

	/**
	 * Output page
	 */
	public function page_cb() {

		// handle post
		$this->handle_post();

		// load correct view
		$this->load_view();
	}

}