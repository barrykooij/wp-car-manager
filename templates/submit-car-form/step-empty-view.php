<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

printf( __( 'You are redirected to the next step, %sclick here%s if nothing happens.', 'wp-car-manager' ), '<a href="' . $redirect_url . '">', '</a>' );
?>
<script type="text/javascript">window.location="<?php echo $redirect_url; ?>";</script>