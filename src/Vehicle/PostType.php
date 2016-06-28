<?php

namespace Never5\WPCarManager\Vehicle;

class PostType {

	const VEHICLE = 'wpcm_vehicle';

	public static function register() {

		$labels = array(
			'name'               => _x( 'Car Listings', 'Post Type General Name', 'wp-car-manager' ),
			'singular_name'      => _x( 'Car', 'Post Type Singular Name', 'wp-car-manager' ),
			'menu_name'          => __( 'Car Listings', 'wp-car-manager' ),
			'name_admin_bar'     => __( 'Car Listings', 'wp-car-manager' ),
			'parent_item_colon'  => __( 'Parent Car:', 'wp-car-manager' ),
			'all_items'          => __( 'All Car Listings', 'wp-car-manager' ),
			'add_new_item'       => __( 'Add New Car Listing', 'wp-car-manager' ),
			'add_new'            => __( 'Add New Listing', 'wp-car-manager' ),
			'new_item'           => __( 'New Car', 'wp-car-manager' ),
			'edit_item'          => __( 'Edit Car', 'wp-car-manager' ),
			'update_item'        => __( 'Update Car', 'wp-car-manager' ),
			'view_item'          => __( 'View Car', 'wp-car-manager' ),
			'search_items'       => __( 'Search Car', 'wp-car-manager' ),
			'not_found'          => __( 'No cars found', 'wp-car-manager' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'wp-car-manager' ),
		);
		$args   = array(
			'label'               => __( 'vehicle', 'wp-car-manager' ),
			'description'         => __( 'Cars', 'wp-car-manager' ),
			'labels'              => $labels,
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'author',
				'thumbnail',
				'revisions',
			),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => '',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'car_listing',
			'capabilities'        => array(
				'publish_posts'       => 'publish_car_listings',
				'edit_posts'          => 'edit_car_listings',
				'edit_others_posts'   => 'edit_others_car_listings',
				'delete_posts'        => 'delete_car_listings',
				'delete_others_posts' => 'delete_others_car_listings',
				'read_private_posts'  => 'read_private_car_listings',
				'edit_post'           => 'edit_car_listing',
				'delete_post'         => 'delete_car_listing',
				'read_post'           => 'read_car_listing',
			),
			'rewrite'             => array(
				'slug'       => _x( 'vehicle', 'post type slug', 'wp-car-manager' ),
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			)
		);

		register_post_type( self::VEHICLE, $args );
	}

}