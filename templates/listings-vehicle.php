<?php

/**
 * wpcm_before_listings_vehicle hook
 */
do_action( 'wpcm_before_listings_vehicle' );
?>
	<div class="wpcm-vehicle-listings">

		<div class="wpcm-vehicle-filters">
			<?php
			/**
			 * wpcm_listings_vehicle_filters hook
			 */
			do_action( 'wpcm_listings_vehicle_filters' );
			?>
		</div>

		<div class="wpcm-vehicle-results-wrapper">
			<?php
			/**
			 * wpcm_listings_vehicle_results hook
			 */
			do_action( 'wpcm_listings_vehicle_results' );
			?>
		</div>
	</div>
<?php
/**
 * wpcm_after_listings_vehicle hook
 */
do_action( 'wpcm_after_listings_vehicle' );