<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// get active tab
$active_tab = ( isset( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : 'general' );
?>
<div class="wrap nosubsub wpcm-page-settings">
	<h2><?php _e( 'Settings', 'wp-car-manager' ); ?></h2>

	<form method="post" action="options.php">

		<?php settings_fields( 'wp-car-manager' ); ?>

		<h2 class="nav-tab-wrapper">
			<?php
			foreach ( $fields as $key => $section ) {

				// check if tab is active
				$active = ( ( $key == $active_tab ) ? 'nav-tab-active' : '' );

				echo '<a href="#settings-' . sanitize_title( $key ) . '" class="nav-tab ' . $active . '"">' . esc_html( $section[0] ) . '</a>';
			}
			?>
		</h2><br/>

		<?php

		// display success message
		if ( ! empty( $_GET['settings-updated'] ) ) {
			echo '<div class="updated notice is-dismissible"><p>' . __( 'Settings successfully saved', 'wp-car-manager' ) . '</p></div>';
		}

		// loop through sections
		foreach ( $fields as $key => $section ) {

			// check if we're showing this tab
			$show = ( ( $key == $active_tab ) ? '' : 'hidden' );

			echo '<div id="settings-' . sanitize_title( $key ) . '" class="settings_panel ' . $show . '">';
			echo '<table class="form-table">';

			// loop through fields
			foreach ( $section[1] as $option ) {

				// placeholder
				$placeholder = ( ! empty( $option['placeholder'] ) ) ? 'placeholder="' . $option['placeholder'] . '"' : '';

				// label
				echo '<tr valign="top"><th scope="row"><label for="setting-' . $option['name'] . '">' . $option['label'] . '</a></th><td>';

				if ( ! isset( $option['type'] ) ) {
					$option['type'] = '';
				}

				// get value
				$value = wp_car_manager()->service( 'settings' )->get_option( $option['name'] );

				// switch type
				switch ( $option['type'] ) {
					case "checkbox" :
						?><label><input id="setting-<?php echo $option['name']; ?>"
						                name="wpcm_<?php echo $option['name']; ?>" type="checkbox"
						                value="1" <?php checked( '1', $value ); ?> /> <?php echo $option['cb_label']; ?>
						</label><?php
						if ( $option['desc'] ) {
							echo ' <p class="wpcm-description">' . $option['desc'] . '</p>';
						}
						break;
					case "textarea" :
						?><textarea id="setting-<?php echo $option['name']; ?>" class="large-text" cols="50"
						            rows="3"
						            name="wpcm_<?php echo $option['name']; ?>" <?php echo $placeholder; ?>><?php echo esc_textarea( $value ); ?></textarea><?php
						if ( $option['desc'] ) {
							echo ' <p class="wpcm-description">' . $option['desc'] . '</p>';
						}
						break;
					case "select" :
						?><select id="setting-<?php echo $option['name']; ?>" class="regular-text"
						          name="wpcm_<?php echo $option['name']; ?>"><?php
						foreach ( $option['options'] as $key => $name ) {
							echo '<option value="' . esc_attr( $key ) . '" ' . selected( $value, $key, false ) . '>' . esc_html( $name ) . '</option>';
						}
						?></select><?php
						if ( $option['desc'] ) {
							echo ' <p class="wpcm-description">' . $option['desc'] . '</p>';
						}
						break;
					default :
						?><input id="setting-<?php echo $option['name']; ?>" class="regular-text" type="text"
						         name="wpcm_<?php echo $option['name']; ?>"
						         value="<?php esc_attr_e( $value ); ?>" <?php echo $placeholder; ?> /><?php
						if ( $option['desc'] ) {
							echo ' <p class="wpcm-description">' . $option['desc'] . '</p>';
						}
						break;
				}
				echo '</td></tr>';
			}
			echo '</table></div>';
		}
		?>
		<p class="submit">
			<input type="submit" class="button-primary"
			       value="<?php _e( 'Save Changes', 'wp-car-manager' ); ?>"/>
		</p>
	</form>


</div>