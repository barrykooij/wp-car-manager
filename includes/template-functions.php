<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'wpcm_output_content_wrapper' ) ) {
	function wpcm_output_content_wrapper() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'global/wrapper-start' );
	}
}
if ( ! function_exists( 'wpcm_output_content_wrapper_end' ) ) {
	function wpcm_output_content_wrapper_end() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'global/wrapper-end' );
	}
}

/**
 * SINGLE VEHICLE
 */
if ( ! function_exists( 'wpcm_template_vehicle_images' ) ) {
	function wpcm_template_vehicle_images() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/image' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_thumbnails' ) ) {
	function wpcm_template_vehicle_thumbnails() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/thumbnails' );
	}
}

if ( ! function_exists( 'wpcm_template_single_title' ) ) {
	function wpcm_template_single_title() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/title' );
	}
}

if ( ! function_exists( 'wpcm_template_single_price' ) ) {
	function wpcm_template_single_price() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/price' );
	}
}

if ( ! function_exists( 'wpcm_template_single_summary_data' ) ) {
	function wpcm_template_single_summary_data() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/summary-data' );
	}
}

if ( ! function_exists( 'wpcm_template_single_data' ) ) {
	function wpcm_template_single_data() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/data' );
	}
}

if ( ! function_exists( 'wpcm_template_single_content' ) ) {
	function wpcm_template_single_content() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/content' );
	}
}

if ( ! function_exists( 'wpcm_template_single_features' ) ) {
	function wpcm_template_single_features() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/features' );
	}
}

if ( ! function_exists( 'wpcm_template_single_contact' ) ) {
	function wpcm_template_single_contact() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/contact' );
	}
}

/**
 * LISTINGS VEHICLE
 */
if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_nonce' ) ) {
	function wpcm_template_vehicle_listings_filters_nonce() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/nonce' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_make' ) ) {
	function wpcm_template_vehicle_listings_filters_make() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/make' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_model' ) ) {
	function wpcm_template_vehicle_listings_filters_model() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/model' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_price' ) ) {
	function wpcm_template_vehicle_listings_filters_price() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/price' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_frdate' ) ) {
	function wpcm_template_vehicle_listings_filters_frdate() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/frdate' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_mileage' ) ) {
	function wpcm_template_vehicle_listings_filters_mileage() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/mileage' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_filters_button' ) ) {
	function wpcm_template_vehicle_listings_filters_button() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/filters/button' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_start' ) ) {
	function wpcm_template_vehicle_listings_start() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/start' );
	}
}

if ( ! function_exists( 'wpcm_template_vehicle_listings_end' ) ) {
	function wpcm_template_vehicle_listings_end() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'listings/end' );
	}
}