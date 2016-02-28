<h2><?php _e( 'Car Features', 'wp-car-manager' ); ?></h2>
<fieldset class="wpcm-fieldset-features">
	<div class="wpcm-field wpcm-field-fw">
		<ul class="wpcm-form-features">
			<?php foreach ( $features as $feature ): ?>
				<?php $checked = ( ( in_array( $feature->term_id, $vehicle_features ) ) ? ' checked="checked"' : '' ); ?>
				<li>
					<label for="wpcm-form-<?php esc_attr_e( $feature->slug ); ?>">
						<input type="checkbox" name="wpcm_submit_car[features][]"
						       id="wpcm-form-<?php esc_attr_e( $feature->slug ); ?>"
						       value="<?php esc_attr_e( $feature->term_id ); ?>"<?php echo $checked; ?> />
						<?php echo $feature->name; ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</fieldset>