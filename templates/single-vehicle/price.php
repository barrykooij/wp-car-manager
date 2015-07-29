<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


global $vehicle;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<p class="price"><?php echo $vehicle->get_formatted_price(); ?></p>

	<meta itemprop="price" content="<?php echo $vehicle->get_price(); ?>"/>
	<meta itemprop="priceCurrency" content="<?php echo wp_car_manager()->service( 'settings' )->get( 'currency' ); ?>"/>

</div>
