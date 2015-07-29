<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;

/**
 * wpcm_before_single_vehicle hook
 */
do_action( 'wpcm_before_single_vehicle' );

echo '<pre>';
print_r($vehicle);
echo '</pre>';

?>
	<div itemscope id="vehicle-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		/**
		 * vehicle_before_single_product_summary hook
		 *
		 * @hooked wpcm_show_vehicle_images - 20
		 */
		do_action( 'wpcm_before_single_vehicle_summary' );
		?>


		<div class="summary entry-summary">

			<?php
			/**
			 * vehicle_single_vehicle_summary hook
			 *
			 * @hooked vehicle_template_single_title - 5
			 * @hooked vehicle_template_single_rating - 10
			 * @hooked vehicle_template_single_price - 10
			 * @hooked vehicle_template_single_excerpt - 20
			 * @hooked vehicle_template_single_meta - 40
			 * @hooked vehic  le_template_single_sharing - 50
			 */
			do_action( 'wpcm_single_vehicle_summary' );
			?>

		</div>

		<?php
		/**
		 * vehicle_after_single_product_summary hook
		 *
		 * @hooked vehicle_output_product_data_tabs - 10
		 * @hooked vehicle_upsell_display - 15
		 * @hooked vehicle_output_related_products - 20
		 */
		do_action( 'wpcm_after_single_vehicle_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>"/>

	</div>

<?php do_action( 'wpcm_after_single_vehicle' ); ?>