<div class="wpcm-vehicle-sort">
	<label for="wpcm-sort">
		<?php _e( 'Sort by:', 'wp-car-manager' ); ?>
	</label>
	<select id="wpcm-sort">
		<?php foreach (
			apply_filters( 'wpcm_filter_sort', array(
				'price-asc'    => __( 'Price (low-high)', 'wp-car-manager' ),
				'price-desc'   => __( 'Price (high-low)', 'wp-car-manager' ),
				'frdate-asc'   => __( 'Year (old-new)', 'wp-car-manager' ),
				'frdate-desc'  => __( 'Year (new-old)', 'wp-car-manager' ),
				'mileage-asc'  => __( 'Mileage (low-high)', 'wp-car-manager' ),
				'mileage-desc' => __( 'Mileage (high-low)', 'wp-car-manager' ),
				'date-asc'     => __( 'Date (old-new)', 'wp-car-manager' ),
				'date-desc'    => __( 'Date (new-old)', 'wp-car-manager' ),
			) ) as $sort_key => $sort_val
		) : ?>
			<option
				value="<?php echo esc_attr( $sort_key ); ?>"<?php selected( $atts['sort'], $sort_key ); ?>><?php esc_html_e( $sort_val ); ?></option>
		<?php endforeach; ?>
	</select>
</div>
