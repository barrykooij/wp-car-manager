<?php
namespace Never5\WPCarManager\Admin\MetaBox;

use Never5\WPCarManager;

abstract class MetaBox implements iMetaBox {

	/** @var String */
	protected $id = '';

	/** @var String */
	protected $label;

	/** @var String */
	protected $context;

	/** @var String */
	protected $priority;

	public function __construct( $id, $label, $context = 'advanced', $priority = 'default' ) {
		$this->id       = $id;
		$this->label    = $label;
		$this->context  = $context;
		$this->priority = $priority;
	}

	/**
	 * Setup meta box
	 */
	public function init() {

		// only continue if the meta box has an id
		if ( '' === $this->id ) {
			return;
		}

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
	}

	/**
	 * Add meta box
	 */
	public function add_meta_box() {
		add_meta_box( 'wpcm-' . $this->id, $this->label,
			array( $this, 'meta_box_output' ), WPCarManager\Vehicle\PostType::VEHICLE, $this->context, $this->priority );
	}

	/**
	 * Generate nonce key
	 *
	 * @return string
	 */
	private function get_nonce_key() {
		return 'wpcm_nonce_' . $this->id;
	}

	/**
	 * Generate nonce action
	 *
	 * @return string
	 */
	private function get_nonce_action() {
		return sha1( $this->id . $this->context . $this->priority . '#never5' );
	}

	/**
	 * Output nonce field
	 */
	protected function output_nonce() {
		wp_nonce_field( $this->get_nonce_action(), $this->get_nonce_key() );
	}

	/**
	 * check if nonce is correct
	 *
	 * @return bool
	 */
	protected function check_nonce() {

		// nonce check
		if ( isset( $_POST[$this->get_nonce_key()] ) && wp_verify_nonce( $_POST[ $this->get_nonce_key() ], $this->get_nonce_action() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if we should save meta data
	 *
	 * @param \WP_Post $post
	 *
	 * @return bool
	 */
	protected function should_save( $post ) {
		//  check nonce
		if ( ! $this->check_nonce() ) {
			return false;
		}

		// autosave check
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		// post type check
		if ( WPCarManager\Vehicle\PostType::VEHICLE != $post->post_type ) {
			return false;
		}

		// capabilities
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return false;
		}

		return true;
	}

}