<?php

namespace Never5\WPCarManager;

class Taxonomies {

	const FEATURES = 'wpcm_features';
	const MAKE_MODEL = 'wpcm_make_model';

	/**
	 * Register taxonomy: features
	 */
	public static function register_features() {
		$labels  = array(
			'name'                       => _x( 'Features', 'Taxonomy General Name', 'wp-car-manager' ),
			'singular_name'              => _x( 'Feature', 'Taxonomy Singular Name', 'wp-car-manager' ),
			'menu_name'                  => __( 'Features', 'wp-car-manager' ),
			'all_items'                  => __( 'All Features', 'wp-car-manager' ),
			'parent_item'                => __( 'Parent Feature', 'wp-car-manager' ),
			'parent_item_colon'          => __( 'Parent Feature:', 'wp-car-manager' ),
			'new_item_name'              => __( 'New Feature Name', 'wp-car-manager' ),
			'add_new_item'               => __( 'Add New Feature', 'wp-car-manager' ),
			'edit_item'                  => __( 'Edit Feature', 'wp-car-manager' ),
			'update_item'                => __( 'Update Feature', 'wp-car-manager' ),
			'view_item'                  => __( 'View Feature', 'wp-car-manager' ),
			'separate_items_with_commas' => __( 'Separate features with commas', 'wp-car-manager' ),
			'add_or_remove_items'        => __( 'Add or remove features', 'wp-car-manager' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wp-car-manager' ),
			'popular_items'              => __( 'Popular features', 'wp-car-manager' ),
			'search_items'               => __( 'Search features', 'wp-car-manager' ),
			'not_found'                  => __( 'Not Found', 'wp-car-manager' ),
		);
		$rewrite = array(
			'slug'         => _x( 'feature', 'taxonomy type slug', 'wp-car-manager' ),
			'with_front'   => true,
			'hierarchical' => false,
		);
		$args    = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'capabilities'      => array(
				'manage_terms' => 'manage_car_listings',
				'edit_terms'   => 'manage_car_listings',
				'delete_terms' => 'manage_car_listings',
				'assign_terms' => 'manage_car_listings',
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'rewrite'           => $rewrite,
		);
		register_taxonomy( self::FEATURES, array( 'wpcm_vehicle' ), $args );

		// add explanatory text for features
		add_action( 'add_tag_form_pre', array( __CLASS__, 'add_explanatory_features_text' ) );
	}

	/**
	 * Add explanatory text for features
	 *
	 * @param string $taxonomy
	 */
	public static function add_explanatory_features_text( $taxonomy ) {
		if ( 'wpcm_features' != $taxonomy ) {
			return;
		}
		echo '<div class="wpcm-taxonomy-explanation">';
		echo '<h2>What are Features?</h2>';
		echo "<p>" . sprintf(
				__( "WP Car Manager Features are the place to add all the 'features' your vehicle has so you don't have to re-type the same feature every time. Examples of commonly used features are %s, %s, %s and %s but you are free to enter any feature you like. Vehicle features are listed in a nice list on the vehicle detail page.", 'wp-car-manager' ),
				"<strong>" . __( 'ABS', 'wp-car-manager' ) . "</strong>",
				"<strong>" . __( 'Airbag', 'wp-car-manager' ) . "</strong>",
				"<strong>" . __( 'ESP', 'wp-car-manager' ) . "</strong>",
				"<strong>" . __( 'Radio', 'wp-car-manager' ) . "</strong>"
			) . "</p>";
		echo '</div>';
	}

	/**
	 * Register taxonomy: model_make
	 */
	public static function register_model_make() {
		$labels  = array(
			'name'                       => _x( 'Makes', 'Taxonomy General Name', 'wp-car-manager' ),
			'singular_name'              => _x( 'Make', 'Taxonomy Singular Name', 'wp-car-manager' ),
			'menu_name'                  => __( 'Makes & Models', 'wp-car-manager' ),
			'all_items'                  => __( 'All Makes', 'wp-car-manager' ),
			'parent_item'                => __( 'Parent Make', 'wp-car-manager' ),
			'parent_item_colon'          => __( 'Parent Make:', 'wp-car-manager' ),
			'new_item_name'              => __( 'New Make Name', 'wp-car-manager' ),
			'add_new_item'               => __( 'Add New Make', 'wp-car-manager' ),
			'edit_item'                  => __( 'Edit Make', 'wp-car-manager' ),
			'update_item'                => __( 'Update Make', 'wp-car-manager' ),
			'view_item'                  => __( 'View Make', 'wp-car-manager' ),
			'separate_items_with_commas' => __( 'Separate makes with commas', 'wp-car-manager' ),
			'add_or_remove_items'        => __( 'Add or remove makes', 'wp-car-manager' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wp-car-manager' ),
			'popular_items'              => __( 'Popular Makes', 'wp-car-manager' ),
			'search_items'               => __( 'Search Makes', 'wp-car-manager' ),
			'not_found'                  => __( 'Not Found', 'wp-car-manager' ),
		);
		$rewrite = array(
			'slug'         => _x( 'make', 'taxonomy type slug', 'wp-car-manager' ),
			'with_front'   => true,
			'hierarchical' => true,
		);
		$args    = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'capabilities'      => array(
				'manage_terms' => 'manage_car_listings',
				'edit_terms'   => 'manage_car_listings',
				'delete_terms' => 'manage_car_listings',
				'assign_terms' => 'manage_car_listings',
			),
			'show_ui'           => false,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'rewrite'           => $rewrite,
		);
		register_taxonomy( self::MAKE_MODEL, array( 'wpcm_vehicle' ), $args );
	}

}