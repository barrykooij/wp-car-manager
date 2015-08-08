<div class="wpcm-filter wpcm-filter-frdate">
	<label><?php _e( 'Min Year', 'wp-car-manager' ); ?></label>
	<select name="frdate_to" data-placeholder="<?php _e( 'All', 'wp-car-manager' ); ?>">
		<option value="0"><?php _e('All', 'wp-car-manager'); ?></option>
		<?php for ( $i = 2015; $i >= 1900; $i -- ) : ?>
			<?php
			if ( $i < 1970 && 0 != ( $i % 5 ) ) {
				continue;
			}
			?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
</div>