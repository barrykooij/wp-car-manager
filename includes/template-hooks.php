<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Before Summary Box
 *
 * @see wpcm_template_vehicle_preview_bar()
 */
add_action( 'wpcm_before_single_vehicle', 'wpcm_template_vehicle_preview_bar', 10 );
add_action( 'wpcm_before_single_vehicle', 'wpcm_template_vehicle_pending_bar', 10 );
add_action( 'wpcm_before_single_vehicle', 'wpcm_template_vehicle_expired_bar', 10 );

/**
 * Before Summary Box
 *
 * @see wpcm_template_vehicle_images()
 * @see wpcm_template_vehicle_thumbnails()
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

// Remove the power hp from data template parts as we display this in the power kw template part
add_filter( 'wpcm_single_vehicle_data_fields', 'wpcm_template_data_remove_power_hp', 10, 2 );

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

/**
 * Listings Pagination
 */
add_action( 'wpcm_after_listings_results', 'wpcm_template_vehicle_listings_pagination', 10 );

/**
 * Sold sign
 */
add_action( 'wpcm_vehicle_listings_item_image_start', 'wpcm_template_sold_sign', 10, 1 );
add_action( 'wpcm_vehicle_dashboard_item_image_start', 'wpcm_template_sold_sign', 10, 1 );
add_action( 'wpcm_vehicle_thumbnails', 'wpcm_template_sold_sign', 15, 1 );

/**
 * Review sign
 */
add_action( 'wpcm_vehicle_dashboard_item_image_start', 'wpcm_template_review_sign', 10, 1 );

/**
 ************************ CAR SUBMISSION ************************
 */

add_action( 'wpcm_submit_car_form_login', 'wpcm_template_submit_car_form_fields_account_signin', 15 );
add_action( 'wpcm_submit_car_form_fields', 'wpcm_template_submit_car_form_fields_car_title', 15 );
add_action( 'wpcm_submit_car_form_fields', 'wpcm_template_submit_car_form_fields_car_description', 20 );
add_action( 'wpcm_submit_car_form_fields', 'wpcm_template_submit_car_form_fields_car_data', 25 );
add_action( 'wpcm_submit_car_form_fields', 'wpcm_template_submit_car_form_fields_car_features', 30 );
add_action( 'wpcm_submit_car_form_fields', 'wpcm_template_submit_car_form_fields_car_images', 40 );


add_action( 'wpcm_submit_car_form_disabled', 'wpcm_template_submit_car_form_disabled', 15 );

/**
 ************************ DASHBOARD ************************
 */

/**
 * Add new listing button on dashboard
 */
add_action( 'the_title', 'wpcm_template_dashboard_add_new_listing_button' );

/**
 * Vehicle Dashboard Results
 */
add_action( 'wpcm_dashboard_results', 'wpcm_template_dashboard_list_start', 10 );
add_action( 'wpcm_dashboard_results', 'wpcm_template_dashboard_list_end', 15 );

/**
 * Vehicle Dashboard Item Buttons
 */
add_action( 'wpcm_dashboard_item_actions', 'wpcm_template_dashboard_button_edit', 10 );
add_action( 'wpcm_dashboard_item_actions', 'wpcm_template_dashboard_button_delete', 10 );
//add_action( 'wpcm_dashboard_item_actions', 'wpcm_template_dashboard_button_renew', 10 );