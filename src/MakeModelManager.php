<?php

namespace Never5\WPCarManager;

class MakeModelManager {

	/**
	 * Get makes
	 *
	 * @return array
	 */
	public function get_makes() {

		// makes array
		$makes = array();

		// get terms
		$terms = get_terms( Taxonomies::MAKE_MODEL, array(
			'hide_empty'   => false,
			'hierarchical' => false,
			'parent'       => 0
		) );

		// count & loop
		if ( count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {

				// add to makes array
				$makes[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug
				);

			}
		}

		// return makes
		return $makes;
	}

	/**
	 * Get models of make
	 *
	 * @param int $make_id
	 *
	 * @return array
	 */
	public function get_models( $make_id ) {

		// models array
		$models = array();

		// get terms
		$terms = get_terms( Taxonomies::MAKE_MODEL, array(
			'hide_empty'   => false,
			'hierarchical' => false,
			'parent'       => $make_id

		) );

		// count & loop
		if ( count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {

				// add to models array
				$models[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug
				);

			}
		}

		// return models
		return $models;
	}

}