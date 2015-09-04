<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $vehicle;
?>
<div class="wpcm-images">

	<?php

	if ( has_post_thumbnail() ) {

		$image_title   = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
		$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
		$image         = get_the_post_thumbnail( get_the_ID(), apply_filters( 'wpcm_single_vehicle_large_thumbnail_size', 'wpcm_vehicle_single' ), array(
			'title' => $image_title,
			'alt'   => $image_title
		) );

		$attachment_count = count( $vehicle->get_gallery_attachment_ids() );

		if ( $attachment_count > 0 ) {
			$gallery = '[vehicle-gallery]';
		} else {
			$gallery = '';
		}

		$image_html = sprintf( '<a href="%s" itemprop="image" class="wpcm-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>', $image_link, $image_caption, $gallery, $image ); // use itemprop="image"

	} else {

		$placeholder = apply_filters( 'wpcm_single_vehicle_thumbnail_placeholder', wp_car_manager()->service( 'file' )->image_url( 'placeholder-single.png' ), $vehicle );
		$image_html  = sprintf( '<img src="%s" alt="%s" />', $placeholder, __( 'Placeholder', 'wp-car-manager' ) );

	}

	echo apply_filters( 'wpcm_single_vehicle_image_html', $image_html, get_the_ID() );
	?>

	<?php do_action( 'wpcm_vehicle_thumbnails' ); ?>

</div>