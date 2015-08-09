<?php

// get and prep models
$models_select = array( 0 => __( 'Select Model', 'wp-car-manager' ) );
if ( $vehicle->get_make() != 0 ) {
	$models = wp_car_manager()->service( 'make_model_manager' )->get_models( $vehicle->get_make() );
	if ( count( $models ) > 0 ) {
		foreach ( $models as $model ) {
			$models_select[ $model['id'] ] = $model['name'];
		}
	}
}


?>
<select name="<?php echo $mb_prefix; ?>[<?php echo $field['key']; ?>]" id="<?php echo $field['key']; ?>">
	<?php
	if ( isset( $models_select ) && count( $models_select ) > 0 ) {
		foreach ( $models_select as $option_key => $option_value ) {
			?>
			<option
				value="<?php echo $option_key; ?>"<?php selected( $option_key, $value ); ?>><?php echo $option_value; ?></option>
			<?php
		}
	}
	?>
</select>
