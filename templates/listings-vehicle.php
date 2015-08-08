<?php

/**
 * wpcm_before_listings_vehicle hook
 */
do_action( 'wpcm_before_listings' );
?>
	<div class="wpcm-vehicle-listings">

		<?php do_action( 'wpcm_before_listings_filter' ); ?>

		<div class="wpcm-vehicle-filters">
			<?php
			/**
			 * wpcm_listings_vehicle_filters hook
			 */
			do_action( 'wpcm_listings_vehicle_filters' );
			?>
		</div>

		<?php do_action( 'wpcm_after_listings_filter' ); ?>
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