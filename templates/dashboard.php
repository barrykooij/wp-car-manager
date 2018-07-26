<?php

/**
 * wpcm_before_dashboard hook
 */
do_action( 'wpcm_before_dashboard' );
?>
	<div class="wpcm-dashboard">

		<?php do_action( 'wpcm_before_profile' ); ?>

        <div class="wpcm-dashboard-profile">
			<?php
			/**
			 * wpcm_dashboard_profile hook
			 */
			do_action( 'wpcm_dashboard_profile' );
			?>
        </div>

		<?php do_action( 'wpcm_after_profile' ); ?>

		<?php do_action( 'wpcm_before_dashboard_results' ); ?>

		<div class="wpcm-dashboard-wrapper">
			<?php
			/**
			 * wpcm_listings_vehicle_results hook
			 */
			do_action( 'wpcm_dashboard_results' );
			?>
		</div>

		<?php do_action( 'wpcm_after_dashboard_results' ); ?>
	</div>
<?php
/**
 * wpcm_after_dashboard hook
 */
do_action( 'wpcm_after_dashboard' );