<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * wpcm_before_single_vehicle hook
 */
do_action( 'wpcm_before_single_vehicle' );
?>
	<div class="wpcm-vehicle-head">
		<?php
		/**
		 * wpcm_after_vehicle_summary hook
		 *
		 * @hooked wpcm_show_vehicle_images - 10
		 */
		do_action( 'wpcm_before_vehicle_summary' );
		?>

		<div class="wpcm-summary">
			<?php
			/**
			 * wpcm_vehicle_summary hook
			 *
			 * @hooked wpcm_template_single_price - 10
			 * @hooked wpcm_template_single_summary_data - 20
			 * @hooked wpcm_template_single_contact - 30
			 */
			do_action( 'wpcm_vehicle_summary' );
			?>
		</div>

		<?php
		/**
		 * wpcm_after_vehicle_summary hook
		 */
		do_action( 'wpcm_after_vehicle_summary' );
		?>
	</div>

	<div class="wpcm-vehicle-content entry-content">
		<?php
		/**
		 * vehicle_single_vehicle_summary hook
		 *
		 * @hooked wpcm_template_single_data - 10
		 * @hooked wpcm_template_single_content - 20
		 * @hooked wpcm_template_single_features - 30
		 */
		do_action( 'wpcm_vehicle_content' );
		?>
	</div>

	<meta itemprop="url" content="<?php the_permalink(); ?>"/>

<?php do_action( 'wpcm_after_single_vehicle' ); ?>