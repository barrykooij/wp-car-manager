<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>

<?php if ( isset( $fields ) && count( $fields ) > 0 ) : ?>
	<table cellpadding="0" cellspacing="0" border="0">
		<?php foreach ( $fields as $field ) : ?>
			<tr>
				<th><label for="<?php echo $field['key']; ?>"><?php echo $field['label']; ?></label></th>
				<td>
					<?php
					// getter method for value
					$get_method = 'get_' . $field['key'];

					// load template part
					wp_car_manager()->service( 'view_manager' )->display( 'meta-box/input/' . $field['type'], array(
						'mb_prefix' => $mb_prefix,
						'field'     => $field,
						'value'     => $vehicle->$get_method(),
						'vehicle'   => $vehicle
					) );
					?>
				</td>
			</tr>

		<?php endforeach; ?>
	</table>
<?php endif; ?>