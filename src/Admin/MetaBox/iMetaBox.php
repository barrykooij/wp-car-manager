<?php

namespace Never5\WPCarManager\Admin\MetaBox;

interface iMetaBox {
	public function meta_box_output( $post );

	public function save_meta_box( $post_id, $post );
}