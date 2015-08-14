<div class="wpcm-filter wpcm-filter-price">
	<label for=""><?php _e( 'Max Price', 'wp-car-manager' ); ?></label>
	<select name="price_to" data-placeholder="<?php _e( 'All', 'wp-car-manager' ); ?>">
		<option value="0"><?php _e('All', 'wp-car-manager'); ?></option>
		<?php foreach (
			apply_filters( 'wpcm_filter_price', array(
				500,
				1000,
				2000,
				3000,
				4000,
				5000,
				6000,
				7000,
				8000,
				9000,
				10000,
				12500,
				15000,
				17500,
				20000,
				25000,
				30000,
				40000,
				50000,
				75000,
				100000
			) ) as $price
		) : ?>
			<option value="<?php echo esc_attr( $price ); ?>"><?php echo Never5\WPCarManager\Helper\Format::price( $price ); ?></option>
		<?php endforeach; ?>
	</select>
</div>