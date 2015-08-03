<?php

$models        = wp_car_manager()->service( 'make_model_manager' )->get_models($vehicle->get_make());
$models_select = array( 0 => __( 'Select Model', 'wp-car-manager' ) );
if ( count( $models ) > 0 ) {
	foreach ( $models as $model ) {
		$models_select[ $model['id'] ] = $model['name'];
	}
}


?>
<label for="<?php echo $field['key']; ?>">
	<span><?php echo $field['label']; ?></span>
	<select name="<?php echo $mb_prefix; ?>[<?php echo $field['key']; ?>]" id="<?php echo $field['key']; ?>">
		<?php
		if ( isset( $models_select ) && count( $models_select ) > 0 ) {
			foreach ( $models_select as $option_key => $option_value ) {
				?>
				<option value="<?php echo $option_key; ?>"<?php selected( $option_key, $value ); ?>><?php echo $option_value; ?></option>
				<?php
			}
		}
		?>
	</select>
</label>