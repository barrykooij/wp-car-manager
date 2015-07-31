<?php

namespace Never5\WPCarManager;

class Taxonomies {

	const FEATURES = 'wpcm_features';

	public static function register() {
		$labels = array(
			'name'                       => _x( 'Features', 'Taxonomy General Name', 'loel-txt-domain' ),
			'singular_name'              => _x( 'Feature', 'Taxonomy Singular Name', 'loel-txt-domain' ),
			'menu_name'                  => __( 'Features', 'loel-txt-domain' ),
			'all_items'                  => __( 'All Features', 'loel-txt-domain' ),
			'parent_item'                => __( 'Parent Feature', 'loel-txt-domain' ),
			'parent_item_colon'          => __( 'Parent Feature:', 'loel-txt-domain' ),
			'new_item_name'              => __( 'New Feature Name', 'loel-txt-domain' ),
			'add_new_item'               => __( 'Add New Feature', 'loel-txt-domain' ),
			'edit_item'                  => __( 'Edit Feature', 'loel-txt-domain' ),
			'update_item'                => __( 'Update Feature', 'loel-txt-domain' ),
			'view_item'                  => __( 'View Feature', 'loel-txt-domain' ),
			'separate_items_with_commas' => __( 'Separate features with commas', 'loel-txt-domain' ),
			'add_or_remove_items'        => __( 'Add or remove features', 'loel-txt-domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'loel-txt-domain' ),
			'popular_items'              => __( 'Popular features', 'loel-txt-domain' ),
			'search_items'               => __( 'Search features', 'loel-txt-domain' ),
			'not_found'                  => __( 'Not Found', 'loel-txt-domain' ),
		);
		$rewrite = array(
			'slug'                       => 'feature',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'rewrite'                    => $rewrite,
		);
		register_taxonomy( self::FEATURES, array( 'wpcm_vehicle' ), $args );
	}

}