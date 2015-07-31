<?php

namespace Never5\WPCarManager\Admin\Page;

class Makes {

	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Makes & Models', 'wp-car-manager' ), __( 'Makes & Models', 'wp-car-manager' ), 'manage_options', 'wpcm-makes', array(
			$this,
			'output'
		) );
	}

	public function output() {
		echo 'hallo';
	}

}