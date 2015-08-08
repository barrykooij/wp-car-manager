<div class="wpcm-filter wpcm-filter-frdate">
	<label for=""><?php _e( 'Min Year', 'wp-car-manager' ); ?></label>
	<select>
		<?php for ( $i = 2015; $i >= 1970; $i -- ) : ?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>

</div>