<?php

namespace Never5\WPCarManager\Vehicle;

/**
 * Class Cron
 * @package Never5\WPCarManager\Vehicle
 *
 * Vehicle related cron-jobs
 */
class Cron {

	/**
	 * Schedule
	 */
	public function schedule() {
		if ( ! wp_next_scheduled( 'wpcm_crob_set_expired' ) ) {

			// Get tonight (which is tomorrow) at 1 minute passed twelve (00:01).
			$tonight = new \DateTime();
			$tonight->modify( '+1 day' );
			$tonight->setTime( 0, 1, 0 );

			// schedule event
			wp_schedule_event( $tonight->getTimestamp(), 'daily', 'wpcm_crob_set_expired' );
		}
	}

	/**
	 * Unschedule
	 */
	public function unschedule() {
		$timestamp = wp_next_scheduled( 'wpcm_crob_set_expired' );

		// unschedule
		if ( false !== $timestamp ) {
			wp_unschedule_event( $timestamp, 'wpcm_crob_set_expired' );
		}
	}

}