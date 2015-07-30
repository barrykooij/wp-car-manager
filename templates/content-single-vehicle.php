<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;

/**
 * wpcm_before_single_vehicle hook
 */
do_action( 'wpcm_before_single_vehicle' );

//echo '<pre>';
//print_r($vehicle);
//echo '</pre>';

?>
	<div id="vehicle-<?php the_ID(); ?>" itemprop="itemOffered" itemscope itemtype="http://schema.org/Car" <?php post_class(); ?>>

		<header class="entry-header">
			<?php
			/**
			 * wpcm_vehicle_header hook
			 *
			 * @hooked vehicle_template_single_title - 5
			 */
			do_action( 'wpcm_vehicle_header' );
			?>
		</header>

		<?php
		/**
		 * wpcm_after_vehicle_summary hook
		 *
		 * @hooked wpcm_show_vehicle_images - 10
		 */
		do_action( 'wpcm_before_vehicle_summary' );
		?>

		<div class="wpcm-summary entry-summary">
			<?php
			/**
			 * wpcm_vehicle_summary hook
			 *
			 * @hooked wpcm_template_single_price - 10
			 * @hooked wpcm_template_single_summary_data - 20
			 */
			do_action( 'wpcm_vehicle_summary' );
			?>
		</div>

		<?php
		/**
		 * wpcm_after_vehicle_summary hook
		 *
		 * @hooked vehicle_output_product_data_tabs - 10
		 * @hooked vehicle_upsell_display - 15
		 * @hooked vehicle_output_related_products - 20
		 */
		do_action( 'wpcm_after_vehicle_summary' );
		?>

		<div class="wpcm-vehicle-content">
			<?php
			/**
			 * vehicle_single_vehicle_summary hook
			 *
			 * @hooked vehicle_template_single_content - 5
			 * @hooked vehicle_template_single_features - 10
			 * @hooked vehicle_template_single_seller_comments - 10
			 */
			do_action( 'wpcm_vehicle_content' );
			?>
		</div>

		<meta itemprop="url" content="<?php the_permalink(); ?>"/>

	</div>

<?php do_action( 'wpcm_after_single_vehicle' ); ?>