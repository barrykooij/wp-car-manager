<?php

namespace Never5\WPCarManager;

/**
 * Class TemplateManager
 * @package Never5\WPCarManager
 */
class TemplateManager {

	/**
	 * Init
	 */
	public function init() {
		add_filter( 'template_include', array( $this, 'override_template' ) );
		add_filter( 'post_class', array( $this, 'filter_post_class' ), 20, 3 );
	}

	/**
	 * Return template path
	 *
	 * @return string
	 */
	public function get_template_path() {
		return apply_filters( 'wpcm_template_path', 'wp-car-manager/' );
	}

	/**
	 * Filter post class
	 *
	 * @param array $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	public function filter_post_class( $classes, $class = '', $post_id = '' ) {
		if ( ! $post_id || PostType::VEHICLE !== get_post_type( $post_id ) ) {
			return $classes;
		}

		if ( false !== ( $key = array_search( 'hentry', $classes ) ) ) {
			unset( $classes[ $key ] );
		}

		return $classes;
	}

	/**
	 * Override WordPress template. Hooked into template_include
	 *
	 * @param string $template
	 *
	 * @return string
	 */
	public function override_template( $template ) {
		$find = array();
		$file = '';

		if ( is_singular( PostType::VEHICLE ) ) {

			$file   = 'single-wpcm_vehicle.php';
			$find[] = $file;
			$find[] = $this->get_template_path() . $file;

			$GLOBALS['vehicle'] = wp_car_manager()->service( 'vehicle_factory' )->make( get_the_ID() );
		}

		if ( $file ) {
			$template = locate_template( array_unique( $find ) );
			if ( ! $template ) {
				$template = wp_car_manager()->service( 'file' )->plugin_path() . '/templates/' . $file;
			}
		}

		return $template;
	}

	/**
	 * Get template part
	 *
	 * @param string $slug
	 * @param string $name
	 * @param array $args
	 *
	 */
	public function get_template_part( $slug, $name = '', $args = array() ) {
		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/wp-car-manager/slug-name.php
		if ( $name ) {
			$template = locate_template( array(
				"{$slug}-{$name}.php",
				$this->get_template_path() . "{$slug}-{$name}.php"
			) );
		}

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( wp_car_manager()->service( 'file' )->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
			$template = wp_car_manager()->service( 'file' )->plugin_path() . "/templates/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wp-car-manager/slug.php
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", $this->get_template_path() . "{$slug}.php" ) );
		}

		// Get default slug.php
		if ( ! $template ) {
			$template = wp_car_manager()->service( 'file' )->plugin_path() . "/templates/{$slug}.php";
		}

		// Allow 3rd party plugin filter template file from their plugin
		if ( $template ) {
			$template = apply_filters( 'wpcm_get_template_part', $template, $slug, $name, $args );
		}

		if ( $template ) {

			// Extract args if there are any
			if ( is_array( $args ) && count( $args ) > 0 ) {
				extract( $args );
			}

			/**
			 * wpcm_before_template_part hook
			 */
			do_action( 'wpcm_before_template_part', $template, $slug, $name, $args );

			// include file
			include( $template );

			/**
			 * wpcm_after_template_part hook
			 */
			do_action( 'wpcm_after_template_part', $template, $slug, $name, $args );

		} else {
			echo '<span style="color:#ff0000;">Template not found: ' . $slug . ( ( '' != $name ) ? '-' . $name : '' ) . '</span><br/>';
		}
	}

}