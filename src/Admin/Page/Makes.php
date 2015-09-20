<?php

namespace Never5\WPCarManager\Admin\Page;

use Never5\WPCarManager\Taxonomies;

class Makes {

	/**
	 * Init page
	 */
	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Makes & Models', 'wp-car-manager' ), __( 'Makes & Models', 'wp-car-manager' ), 'edit_posts', 'wpcm-makes', array(
			$this,
			'page_cb'
		) );
	}

	/**
	 * Handle action if set
	 */
	private function handle_action() {
		if ( isset( $_POST['wpcm_action'] ) ) {

			// check if nonce exists
			if ( ! isset( $_POST['wpcm_make_nonce'] ) ) {
				return;
			}

			// verify nonce
			if ( ! wp_verify_nonce( $_POST['wpcm_make_nonce'], 'wpcm_make_nonce_wow_much_security' ) ) {
				return;
			}

			switch ( $_POST['wpcm_action'] ) {

				case 'edit_term':

					// term id
					$term_id = absint( $_POST['term_id'] );

					// args
					$args = array(
						'name' => $_POST['name'],
						'slug' => $_POST['slug']
					);

					// if make id is set, we set it as parent
					if ( isset( $_POST['make_id'] ) ) {
						$args['parent'] = absint( $_POST['make_id'] );
					}

					// update
					wp_update_term( $term_id, Taxonomies::MAKE_MODEL, array(
						'name' => $args['name'],
						'slug' => $args['slug']
					) );
					break;
				case 'add_term':

					// args
					$args = array(
						'slug' => $_POST['slug']
					);

					// if make id is set, we set it as parent
					if ( isset( $_POST['make_id'] ) ) {
						$args['parent'] = absint( $_POST['make_id'] );
					}

					// add term
					wp_insert_term(
						$_POST['name'],
						Taxonomies::MAKE_MODEL,
						$args
					);

					break;
			}

		} else if ( isset( $_GET['action'] ) ) {
			if ( 'delete' === $_GET['action'] ) {
				// check if nonce exists
				if ( ! isset( $_GET['wpcm_nonce'] ) ) {
					return;
				}

				// verify nonce
				if ( ! wp_verify_nonce( $_GET['wpcm_nonce'], 'wpcm_make_nonce_wow_much_security' ) ) {
					return;
				}

				// check if term id is set
				if ( isset( $_GET['term_id'] ) ) {

					$term_id = absint( $_GET['term_id'] );

					// look for child terms
					$child_terms = get_terms( Taxonomies::MAKE_MODEL, array(
						'hide_empty'   => false,
						'hierarchical' => false,
						'parent'       => $term_id

					) );

					if ( count( $child_terms ) > 0 ) {
						foreach ( $child_terms as $child_term ) {
							wp_delete_term( $child_term->term_id, Taxonomies::MAKE_MODEL );
						}
					}

					// delete term
					wp_delete_term( $term_id, Taxonomies::MAKE_MODEL );
				}
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

			// form action URL
			$form_action_url = admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-makes' );

			// check if make is set
			if ( isset( $_GET['make'] ) ) {
				// add make to form action URL
				$form_action_url = add_query_arg( array( 'make' => absint( $_GET['make'] ) ), $form_action_url );
			}

			// load view
			wp_car_manager()->service( 'view_manager' )->display( 'page/edit-make-model', array(
				'form_action' => $form_action_url,
				'title'       => sprintf( __( 'Edit %s', 'wp-car-manager' ), $term->name ),
				'item'        => array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug
				),
			) );

		} elseif ( isset( $_GET['make'] ) ) {

			// get make
			$make = get_term( absint( $_GET['make'] ), 'wpcm_make_model' );

			// load view
			wp_car_manager()->service( 'view_manager' )->display( 'page/models', array(
				'title' => sprintf( __( '%s Models', 'wp-car-manager' ), $make->name ),
				'items' => wp_car_manager()->service( 'make_model_manager' )->get_models( $make->term_id ),
			) );
		} else {

			// load view
			wp_car_manager()->service( 'view_manager' )->display( 'page/makes', array(
				'title' => __( 'Makes', 'wp-car-manager' ),
				'items' => wp_car_manager()->service( 'make_model_manager' )->get_makes(),
			) );
		}

	}

	/**
	 * Output page
	 */
	public function page_cb() {

		// handle post
		$this->handle_action();

		// load correct view
		$this->load_view();
	}

}