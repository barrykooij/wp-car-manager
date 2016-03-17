<?php

/**
 * wpcm_before_listings_vehicle hook
 */
do_action( 'wpcm_before_listings' );


?>
	<div class="wpcm-vehicle-listings"<?php echo $data_atts; ?>>

		<?php if ( $atts['show_filters'] ) : ?>

			<?php do_action( 'wpcm_before_listings_filter' ); ?>

			<div class="wpcm-vehicle-filters">
				<?php
				/**
				 * wpcm_listings_vehicle_filters hook
				 */
				do_action( 'wpcm_listings_vehicle_filters', $atts );
				?>
			</div>

			<?php do_action( 'wpcm_after_listings_filter' ); ?>

		<?php endif; ?>

		<?php if ( $atts['show_sort'] ) : ?>

			<?php do_action( 'wpcm_before_listings_sort' ); ?>

			<?php
			/**
			 * wpcm_listings_vehicle_sort hook
			 */
			do_action( 'wpcm_listings_vehicle_sort', $atts );
			?>

			<?php do_action( 'wpcm_after_listings_sort' ); ?>

		<?php endif; ?>

		<?php do_action( 'wpcm_before_listings_results' ); ?>

		<div class="wpcm-vehicle-results-wrapper">
			<?php
			/**
			 * wpcm_listings_vehicle_results hook
			 */
			do_action( 'wpcm_listings_vehicle_results' );
			?>
		</div>

		<?php do_action( 'wpcm_after_listings_results' ); ?>
	</div>
<?php
/**
 * wpcm_after_listings_vehicle hook
 */
do_action( 'wpcm_after_listings' );