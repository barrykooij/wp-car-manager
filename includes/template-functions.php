<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'wpcm_output_content_wrapper' ) ) {
	/**
	 * Output the start of the page wrapper.
	 *
	 */
	function wpcm_output_content_wrapper() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'global/wrapper-start' );
	}
}
if ( ! function_exists( 'wpcm_output_content_wrapper_end' ) ) {
	/**
	 * Output the end of the page wrapper.
	 *
	 */
	function wpcm_output_content_wrapper_end() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'global/wrapper-end' );
	}
}

/** Single Vehicle */
if ( ! function_exists( 'wpcm_show_vehicle_images' ) ) {
	/**
	 * Output the product image before the single product summary.
	 *
	 * @subpackage	Product
	 */
	function wpcm_show_vehicle_images() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/image' );
	}
}

if ( ! function_exists( 'wpcm_show_vehicle_thumbnails' ) ) {
	/**
	 * Output the product thumbnails.
	 *
	 * @subpackage	Product
	 */
	function wpcm_show_vehicle_thumbnails() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/thumbnails' );
	}
}

if ( ! function_exists( 'wpcm_template_single_title' ) ) {
	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function wpcm_template_single_title() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/title' );
	}
}

if ( ! function_exists( 'wpcm_template_single_price' ) ) {
	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function wpcm_template_single_price() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/price' );
	}
}

if ( ! function_exists( 'wpcm_template_single_summary_data' ) ) {
	/**
	 * Output the product title.
	 *
	 * @subpackage	Product
	 */
	function wpcm_template_single_summary_data() {
		wp_car_manager()->service( 'template_manager' )->get_template_part( 'single-vehicle/summary-data' );
	}
}

