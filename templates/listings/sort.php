<div class="wpcm-vehicle-sort">
	<label for="wpcm-sort">
		<?php _e( 'Sort by:', 'wp-car-manager' ); ?>
	</label>
	<select id="wpcm-sort">
		<?php foreach (
			apply_filters( 'wpcm_filter_mileage', array(
				'price-asc'    => __( 'Price (low-high)' ),
				'price-desc'   => __( 'Price (high-low)' ),
				'frdate-asc'   => __( 'Year (old-new)' ),
				'frdate-desc'  => __( 'Year (new-old)' ),
				'mileage-asc'  => __( 'Mileage (low-high)' ),
				'mileage-desc' => __( 'Mileage (high-low)' ),
			) ) as $sort_key => $sort_val
		) : ?>
			<option
				value="<?php echo esc_attr( $sort_key ); ?>"><?php esc_html_e( $sort_val ); ?></option>
		<?php endforeach; ?>
	</select>
</div>