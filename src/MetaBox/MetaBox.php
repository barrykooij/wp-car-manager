<?php
namespace Never5\WPCarManager\MetaBox;

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
			array( $this, 'meta_box_output' ), WPCarManager\PostType::PT, $this->context, $this->priority );
	}

}