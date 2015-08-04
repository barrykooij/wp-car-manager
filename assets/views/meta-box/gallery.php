<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>
<div id="car_images_container">
	<ul class="car_images">

		<?php if ( ! empty( $attachments ) ) : ?>
			<?php foreach ( $attachments as $attachment_id ) : ?>
				<li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
					<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ); ?>
					<ul class="actions">
						<li>
							<a href="#" class="delete tips" data-tip="<?php _e( 'Delete image', 'wp-car-manager' ); ?>"><?php _e( 'Delete', 'wp-car-manager' ); ?></a>
						</li>
					</ul>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>

	</ul>

	<input type="hidden" id="car_gallery" name="car_gallery" value="<?php echo esc_attr( $car_gallery ); ?>"/>

</div>
<p class="add_car_images hide-if-no-js">
	<a href="#" data-choose="<?php _e( 'Add Images to Gallery', 'wp-car-manager' ); ?>"
	   data-update="<?php _e( 'Add to gallery', 'wp-car-manager' ); ?>"
	   data-delete="<?php _e( 'Delete image', 'wp-car-manager' ); ?>"
	   data-text="<?php _e( 'Delete', 'wp-car-manager' ); ?>"><?php _e( 'Add gallery images', 'wp-car-manager' ); ?></a>
</p>