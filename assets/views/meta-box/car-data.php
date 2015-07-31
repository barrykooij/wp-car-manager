<?php
if ( isset( $fields ) && count( $fields ) > 0 ) {
	foreach ( $fields as $field ) {

		// getter method for value
		$get_method = 'get_' . $field['key'];

		// load template part
		wp_car_manager()->service( 'view_manager' )->display( 'meta-box/input/' . $field['type'], array(
			'mb_prefix' => $mb_prefix,
			'field'     => $field,
			'value'     => $vehicle->$get_method()
		) );
	}
}