<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

get_header();

?>

<?php
/**
 * wpcm_before_main_content hook
 *
 * @hooked wpcm_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked wpcm_breadcrumb - 20
 */
do_action( 'wpcm_before_main_content' );

?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php wp_car_manager()->service( 'template_manager' )->get_template_part( 'content', 'single-vehicle' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
/**
 * wpcm_after_main_content hook
 *
 * @hooked wpcm_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'wpcm_after_main_content' );
?>

<?php get_footer(); ?>