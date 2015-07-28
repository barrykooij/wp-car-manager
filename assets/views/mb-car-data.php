<?php
if ( isset( $fields ) && count( $fields ) > 0 ) {
	foreach ( $fields as $field ) {
		wp_car_manager()->service( 'view_manager' )->display( 'input/' . $field['type'], array(
			'mb_prefix' => $mb_prefix,
			'field'     => $field,
		) );
	}
}