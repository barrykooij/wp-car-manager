<?php

namespace Never5\WPCarManager;

class MakeModelManager {

	/**
	 * Get make by ID
	 *
	 * @param int $make_id
	 *
	 * @return array
	 */
	public function get_make( $make_id ) {

		$make = array( 'id' => 0, 'name' => '', 'slug' => '' );

		// get terms
		$term = get_term( $make_id, Taxonomies::MAKE_MODEL );

		if ( ! is_wp_error( $term ) && null !== $term ) {
			$make = array(
				'id'   => $term->term_id,
				'name' => $term->name,
				'slug' => $term->slug
			);
		}

		return $make;
	}

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
	 * Get makes map
	 *
	 * @return array
	 */
	public function get_makes_map() {
		$makes        = $this->get_makes();
		$makes_map = array( 0 => __( 'Select Make', 'wp-car-manager' ) );
		if ( count( $makes ) > 0 ) {
			foreach ( $makes as $make ) {
				$makes_map[ $make['id'] ] = $make['name'];
			}
		}
		return $makes_map;
	}

	/**
	 * Get model by ID
	 *
	 * @param int $model_id
	 *
	 * @return array
	 */
	public function get_model( $model_id ) {

		$model = array( 'id' => 0, 'name' => '', 'slug' => '' );

		// get terms
		$term = get_term( $model_id, Taxonomies::MAKE_MODEL );

		if ( ! is_wp_error( $term ) && null !== $term ) {
			$model = array(
				'id'   => $term->term_id,
				'name' => $term->name,
				'slug' => $term->slug
			);
		}

		return $model;
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