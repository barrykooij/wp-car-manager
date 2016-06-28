<?php

namespace Never5\WPCarManager\Util;

class Rewrites {

	/**
	 * Listen to WordPress language changes as this is important for our rewrites
	 */
	public function listen_language_change() {
		add_action( 'update_option_WPLANG', function ( $old_value, $value, $option ) {
			$this->mark_flush_needed();
		}, 10, 3 );
	}

	/**
	 * Set option that we need to flush rewrites
	 */
	public function mark_flush_needed() {
		update_option( 'wpcm_rewrites_need_flush', 1 );
	}

	/**
	 * Flushes rewrites when needed
	 */
	public function maybe_flush() {
		if ( 1 == get_option( 'wpcm_rewrites_need_flush', false ) ) {
			add_action( 'init', function () {
				flush_rewrite_rules();
				delete_option( 'wpcm_rewrites_need_flush' );
			}, 999 );
		}
	}

}