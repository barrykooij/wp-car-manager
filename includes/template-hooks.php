<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

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
 * @see wpcm_template_single_price()
 * @see wpcm_template_single_summary_data()
 * @see wpcm_template_single_contact()
 */
add_action( 'wpcm_vehicle_summary', 'wpcm_template_single_price', 10 );
add_action( 'wpcm_vehicle_summary', 'wpcm_template_single_summary_data', 20 );
add_action( 'wpcm_vehicle_summary', 'wpcm_template_single_contact', 30 );

/**
 * Vehicle Content Box
 */
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_data', 10 );
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_content', 20 );
add_action( 'wpcm_vehicle_content', 'wpcm_template_single_features', 30 );

/**
 ************************ LISTINGS ************************
 */

add_action( 'wpcm_listings_vehicle_sort', 'wpcm_template_vehicle_listings_sort', 10 );

/**
 * Vehicle Before Listings Filters
 */
add_action( 'wpcm_before_listings_results', 'wpcm_template_vehicle_listings_filters_nonce', 10 );

/**
 * Vehicle Listings Filters
 */
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_make', 10 );
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_model', 10 );
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_price', 15 );
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_frdate', 15 );
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_mileage', 15 );
add_action( 'wpcm_listings_vehicle_filters', 'wpcm_template_vehicle_listings_filters_button', 15 );

/**
 * Vehicle Listings Results
 */
add_action( 'wpcm_listings_vehicle_results', 'wpcm_template_vehicle_listings_start', 10 );
add_action( 'wpcm_listings_vehicle_results', 'wpcm_template_vehicle_listings_end', 15 );
