<div class="wpcm-filter wpcm-filter-make">
	<label><?php _e( 'Make', 'wp-car-manager' ); ?></label>
	<select name="make" data-placeholder="<?php esc_attr_e( 'Select Make', 'wp-car-manager' ); ?>"<?php echo(count($makes)<2)?' disabled="disabled"':''; ?>>
		<?php foreach ( $makes as $make_id => $make_name ) : ?>
			<option value="<?php echo esc_attr( $make_id ); ?>"><?php echo esc_html( $make_name ); ?></option>
		<?php endforeach; ?>
	</select>
</div>