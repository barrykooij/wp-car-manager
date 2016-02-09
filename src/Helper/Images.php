<?php
namespace Never5\WPCarManager\Helper;

class Images {

	/**
	 * Get HTML for vehicle image by image ID
	 *
	 * @param int $image_id
	 *
	 * @return string
	 */
	public static function get_image_html( $image_id, $size ) {

		// get image title
		$image_title   = esc_attr( get_the_title( $image_id ) );

		// return the image
		return wp_get_attachment_image( $image_id, $size, 0, $attr = array(
			'title' => $image_title,
			'alt'   => $image_title
		) );
	}

}