<?php

namespace Never5\WPCarManager;

class UserManager {

	/**
	 * Check if current user is allowed to post listing
	 *
	 * @return bool
	 */
	public function can_post_listing() {

		$can_post = true;

		if ( ! is_user_logged_in() ) {

			// get settings
			$account_required = ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_required' ) );
			$account_creation = ( '1' == wp_car_manager()->service( 'settings' )->get_option( 'account_creation' ) );

			// check if account is required but account creation is disabled
			if ( true === $account_required && false === $account_creation ) {
				$can_post = false;
			}
		}

		return apply_filters( 'wpcm_user_can_post_listing', $can_post );
	}

	/**
	 * Check if current user is allowed to edit given listing
	 *
	 * @param int $listing_id
	 *
	 * @return bool
	 */
	public function can_edit_listing( $listing_id ) {

		$can_edit = true;

		// deny access if user is not logged in or the listing id equals zero
		if ( ! is_user_logged_in() || 0 == $listing_id ) {
			$can_edit = false;
		} else {

			/** @var Vehicle\Vehicle $listing */
			$listing = wp_car_manager()->service( 'vehicle_factory' )->make( $listing_id );

			// check if listing author is equal to currently logged in user and if user has permission to edit listing
			if ( $listing->get_author() !== get_current_user_id() && ! current_user_can( 'edit_post', $listing->get_id() )  ) {
				$can_edit = false;
			}
		}

		return apply_filters( 'wpcm_user_can_edit_listing', $can_edit, $listing_id );
	}

}