<?php
echo '<pre>';
print_r( $atts );
echo '</pre>';

/**
 * wpcm_before_archive_vehicle hook
 */
do_action( 'wpcm_before_archive_vehicle' );
?>
	<div class="wpcm-vehicle-archive">

		<div class="wpcm-vehicle-filters">
			<?php
			/**
			 * wpcm_archive_vehicle_filters hook
			 */
			do_action( 'wpcm_archive_vehicle_filters' );
			?>
		</div>

		<div class="wpcm-vehicle-listings-wrapper">
			<?php
			/**
			 * wpcm_archive_vehicle_listings hook
			 */
			do_action( 'wpcm_archive_vehicle_listings' );
			?>
		</div>
	</div>
<?php
/**
 * wpcm_after_archive_vehicle hook
 */
do_action( 'wpcm_after_archive_vehicle' );