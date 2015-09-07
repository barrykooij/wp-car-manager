<?php

namespace Never5\WPCarManager\Admin\MetaBox;

use Never5\WPCarManager;

class ShortDescription extends MetaBox {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'postexcerpt', __( 'Short Description', 'wp-car-manager' ), 'normal', 'high' );
	}

	/**
	 * Override init to remove default excerpt meta box
	 */
	public function init() {
		remove_meta_box( 'postexcerpt', WPCarManager\Vehicle\PostType::VEHICLE, 'normal' );
		parent::init();
	}

	public function meta_box_output( $post ) {
		$settings = array(
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'textarea_name' => 'excerpt',
			'quicktags'     => true,
			'tinymce'       => true,
			'editor_css'    => '<style>#wp-excerpt-editor-container .wp-editor-area{height:200px; width:100%;}</style>'
		);
		wp_editor( htmlspecialchars_decode( $post->post_excerpt ), 'excerpt', $settings );
	}

	public function save_meta_box( $post_id, $post ) {
		// TODO: Implement save_meta_box() method.
	}

}