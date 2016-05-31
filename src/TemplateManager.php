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
		add_filter( 'the_content', array( $this, 'inject_singular_content' ) );
	}

	/**
	 * Return theme template path
	 *
	 * @return string
	 */
	public function get_theme_path() {
		return apply_filters( 'wpcm_theme_template_path', 'wp-car-manager/' );
	}

	/**
	 * Return parent theme if child theme, else return theme
	 *
	 * @return string
	 */
	public function get_theme() {
		$theme = wp_get_theme();

		return ( ( null != $theme->parent ) ? $theme->parent : $theme->template );
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
		if ( ! $post_id || Vehicle\PostType::VEHICLE !== get_post_type( $post_id ) ) {
			return $classes;
		}

		if ( false !== ( $key = array_search( 'hentry', $classes ) ) ) {
			unset( $classes[ $key ] );
		}

		return $classes;
	}

	/**
	 * Inject vehicle singular content into singular page
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function inject_singular_content( $content ) {
		global $post;

		// check if we need to inject
		if ( ! is_singular( Vehicle\PostType::VEHICLE ) || ! in_the_loop() ) {
			return $content;
		}

		// remove filter to prevent crazy loops
		remove_filter( 'the_content', array( $this, 'inject_singular_content' ) );
		
		// check if vehicle actually the post type that's being looped
		if ( Vehicle\PostType::VEHICLE === $post->post_type ) {

			// create vehicle object
			$vehicle = wp_car_manager()->service( 'vehicle_factory' )->make( $post->ID );

			ob_start();

			/**
			 * wpcm_before_main_content hook
			 */
			do_action( 'wpcm_before_single_content', $vehicle );

			// load content-single-vehicle
			$this->get_template_part( 'content', 'single-vehicle', array( 'vehicle' => $vehicle ) );

			/**
			 * wpcm_after_main_content hook
			 */
			do_action( 'wpcm_after_single_content', $vehicle );

			// set new content
			$content = ob_get_clean();
		}

		// add filter back in place
		add_filter( 'the_content', array( $this, 'inject_singular_content' ) );

		// return content
		return apply_filters( 'wpcm_content_single_vehicle', $content, $post );
	}

	/**
	 * Get template part
	 *
	 * @param string $slug
	 * @param string $name
	 * @param array $args
	 * @param string $custom_dir
	 *
	 * @parem string $custom_dir
	 *
	 */
	public function get_template_part( $slug, $name = '', $args = array(), $custom_dir = '' ) {
		$template = '';

		// set template dir
		$template_dir = ( '' !== $custom_dir ) ? $custom_dir : wp_car_manager()->service( 'file' )->plugin_path() . '/templates/';

		// Look in yourtheme/slug-name.php and yourtheme/wp-car-manager/slug-name.php
		if ( $name ) {
			$template = locate_template( array(
				"{$slug}-{$name}.php",
				$this->get_theme_path() . "{$slug}-{$name}.php"
			) );
		}

		// Get default slug-name.php
		if ( ! $template && $name && file_exists( wp_car_manager()->service( 'file' )->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
			$template = $template_dir . $slug . '-' . $name . '.php';
		}

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wp-car-manager/slug.php
		if ( ! $template ) {
			$template = locate_template( array( "{$slug}.php", $this->get_theme_path() . "{$slug}.php" ) );
		}

		// Get default slug.php
		if ( ! $template ) {
			$template = $template_dir . $slug . '.php';
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
			if ( WP_DEBUG ) {
				echo '<span style="color:#ff0000;">Template not found: ' . $slug . ( ( '' != $name ) ? '-' . $name : '' ) . '</span><br/>';
			}
		}
	}

}