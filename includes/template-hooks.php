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
 * Vehicle Head Box
 *
 * @see wpcm_template_single_title()
 * @see wpcm_show_vehicle_images()
 * @see wpcm_show_vehicle_thumbnails()
 */
add_action( 'wpcm_before_single_vehicle_head', 'wpcm_template_single_title', 5 );
add_action( 'wpcm_before_single_vehicle_head', 'wpcm_show_vehicle_images', 20 );
add_action( 'wpcm_vehicle_thumbnails', 'wpcm_show_vehicle_thumbnails', 20 );

/**
 * Vehicle Summary Box
 *
 * @see wpcm_template_single_title()
 * @see wpcm_template_single_price()
 * @see wpcm_template_single_meta()
 * @see wpcm_template_single_sharing()
 */
add_action( 'wpcm_single_vehicle_summary', 'wpcm_template_single_price', 10 );
add_action( 'wpcm_single_vehicle_summary', 'wpcm_template_single_summary_data', 20 );