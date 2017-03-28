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
	 * Get a make array by make name
	 *
	 * @param string $make_name
	 *
	 * @return array
	 */
	public function get_make_by_name( $make_name ) {

		$make = array( 'id' => 0, 'name' => '', 'slug' => '' );

		// get terms
		$term = get_term_by( 'name', $make_name, Taxonomies::MAKE_MODEL );

		if ( ! is_wp_error( $term ) && null !== $term && false !== $term ) {
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
		$makes     = $this->get_makes();
		$makes_map = array( 0 => __( 'Select Make', 'wp-car-manager' ) );
		if ( count( $makes ) > 0 ) {
			foreach ( $makes as $make ) {
				$makes_map[ $make['id'] ] = $make['name'];
			}
		}

		return $makes_map;
	}

	/**
	 * Insert make
	 *
	 * @param string $name
	 * @param string $slug
	 *
	 * @return array
	 */
	public function insert_make( $name, $slug = '' ) {

		$make = array( 'id' => 0, 'name' => '', 'slug' => '' );

		$args = array();

		// args
		if ( ! empty( $slug ) ) {
			$args['slug'] = $slug;
		}

		// add term
		$term_data = wp_insert_term(
			$name,
			Taxonomies::MAKE_MODEL,
			$args
		);

		// fetch make data
		if ( ! is_wp_error( $term_data ) ) {
			$make = $this->get_make( $term_data['term_id'] );
		}

		return $make;

	}

	/**
	 * Update make
	 *
	 * @param array $make ( array( 'id', 'name', 'slug' ) )
	 *
	 * @return bool
	 */
	public function update_make( $make ) {

		// term id
		$term_id = absint( $make['id'] );

		if ( $term_id < 1 ) {
			return false;
		}

		// update
		$res = wp_update_term( $term_id, Taxonomies::MAKE_MODEL, array(
			'name' => $make['name'],
			'slug' => $make['slug']
		) );

		if ( is_wp_error( $res ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Insert model
	 *
	 * @param int $make_id
	 * @param string $name
	 * @param string $slug
	 *
	 * @return array
	 */
	public function insert_model( $make_id, $name, $slug = '' ) {

		$model = array( 'id' => 0, 'name' => '', 'slug' => '' );

		$args = array(
			'parent' => absint( $make_id )
		);

		// args
		if ( ! empty( $slug ) ) {
			$args['slug'] = $slug;
		}

		// add term
		$term_data = wp_insert_term(
			$name,
			Taxonomies::MAKE_MODEL,
			$args
		);

		// fetch make data
		if ( ! is_wp_error( $term_data ) ) {
			$model = $this->get_model( $term_data['term_id'] );
		}

		return $model;

	}

	/**
	 * Update model
	 *
	 * @param array $model ( array( 'id', 'name', 'slug' ) )
	 * @param int $make_id
	 *
	 * @return bool
	 */
	public function update_model( $model, $make_id ) {

		// term id
		$term_id = absint( $model['id'] );

		if ( $term_id < 1 ) {
			return false;
		}

		// update
		$res = wp_update_term( $term_id, Taxonomies::MAKE_MODEL, array(
			'name'   => $model['name'],
			'slug'   => $model['slug'],
			'parent' => absint( $make_id )
		) );

		if ( is_wp_error( $res ) ) {
			return false;
		}

		return true;
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
	 * Get a model array by model name and make id
	 *
	 * @param string $model_name
	 * @param int $make_id
	 *
	 * @return array
	 */
	public function get_model_by_name( $model_name, $make_id = 0 ) {
		$model = array( 'id' => 0, 'name' => '', 'slug' => '' );

		$args = array(
			'hide_empty'   => false,
			'hierarchical' => false,
			'name'         => $model_name
		);

		if ( $make_id > 0 ) {
			$args['parent'] = $make_id;
		}

		// get terms
		$terms = get_terms( Taxonomies::MAKE_MODEL, $args );

		if ( count( $terms ) > 0 ) {
			$term  = array_shift( $terms );
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