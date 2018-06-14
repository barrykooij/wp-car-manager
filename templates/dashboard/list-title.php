<h2>
    <?php _e( 'My Listings', 'wp-car-manager' ); ?>
    <?php
    wp_car_manager()->service( 'template_manager' )->get_template_part( 'dashboard/buttons/add-new', '', array(
	    'submit_url' => Never5\WPCarManager\Helper\Pages::get_page_submit()
    ) );
    ?>
</h2>