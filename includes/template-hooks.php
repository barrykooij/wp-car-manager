<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Content Wrappers
 *
 * @see wpcm_output_content_wrapper()
 * @see wpcm_output_content_wrapper_end()
 */
add_action( 'wpcm_before_main_content', 'wpcm_output_content_wrapper', 10 );
add_action( 'wpcm_after_main_content', 'wpcm_output_content_wrapper_end', 10 );

/**
 * Vehicle Header Box
 *
 * @see wpcm_template_single_title()
 */
add_action( 'wpcm_vehicle_header', 'wpcm_template_single_title', 5 );

/**
 * Before Summary Box
 *
 * @see wpcm_show_vehicle_images()
 * @see wpcm_show_vehicle_thumbnails()
 */
add_action( 'wpcm_before_vehicle_summary', 'wpcm_template_vehicle_images', 10 );
add_action( 'wpcm_vehicle_thumbnails', 'wpcm_template_vehicle_thumbnails', 20 );

/**
 * Vehicle Summary Box
 *
 * @see wpcm_template_single_title()
 * @see wpcm_template_single_price()
 * @see wpcm_template_single_meta()
 * @see wpcm_template_single_sharing()
 */
add_action( 'wpcm_vehicle_summary', 'wpcm_template_single_price', 10 );
add_action( 'wpcm_vehicle_summary', 'wpcm_template_single_summary_data', 20 );

/**
 * After Summary Box
 *
 * @see wpcm_show_vehicle_images()
 * @see wpcm_show_vehicle_thumbnails()
 */
add_action( 'wpcm_after_vehicle_summary', 'wpcm_template_single_contact', 10 );

/**
 * Vehicle Content Box
 */
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_data', 10 );
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_content', 20 );
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_features', 30 );

/**
 * Vehicle Listings Filters
 */
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters', 10 );

/**
 * Vehicle Listings Results
 */
add_action( 'wpcm_listings_vehicle_results', 'wpcm_template_vehicle_listings_start', 10 );
add_action( 'wpcm_listings_vehicle_results', 'wpcm_template_vehicle_listings_end', 15 );
