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
