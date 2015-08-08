<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;

// get attachment ID's
$attachment_ids = $vehicle->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop    = 0;
	$columns = apply_filters( 'wpcm_vehicle_thumbnails_columns', 4 );
	?>
	<div class="wpcm-thumbnails wpcm-<?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 ) {
				$classes[] = 'first';
			}

			if ( ( $loop + 1 ) % $columns == 0 ) {
				$classes[] = 'last';
			}

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link ) {
				continue;
			}

			$image_title   = esc_attr( get_the_title( $attachment_id ) );
			$image_caption = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

			$image = wp_get_attachment_image( $attachment_id, apply_filters( 'wpcm_single_vehicle_small_thumbnail_size', 'wpcm_vehicle_thumbnail' ), 0, $attr = array(
				'title' => $image_title,
				'alt'   => $image_title
			) );

			$image_class = esc_attr( implode( ' ', $classes ) );

			echo apply_filters( 'wpcm_single_vehicle_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[vehicle-gallery]">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $vehicle->get_id(), $image_class );

			$loop ++;
		}

		?></div>
	<?php
}