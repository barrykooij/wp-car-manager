<div class="wpcm-filter wpcm-filter-make">
	<label><?php _e( 'Make', 'wp-car-manager' ); ?></label>
	<select name="make" data-placeholder="<?php _e( 'Select Make', 'wp-car-manager' ); ?>">
		<?php foreach ( wp_car_manager()->service( 'make_model_manager' )->get_makes_map() as $make_id => $make_name ) : ?>
			<option value="<?php echo $make_id; ?>"><?php echo $make_name; ?></option>
		<?php endforeach; ?>
	</select>
</div>