<?php

namespace Never5\WPCarManager\Admin\Page;

use Never5\WPCarManager\Extension;

class Extensions {

	/**
	 * Init page
	 */
	public function init() {
		add_submenu_page( 'edit.php?post_type=wpcm_vehicle', __( 'Extensions', 'wp-car-manager' ), '<span style="color:#00d198;font-weight:bold;">' . __( 'Extensions', 'wp-car-manager' ) . '</span>', 'edit_posts', 'wpcm-extensions', array(
			$this,
			'page_cb'
		) );
	}

	/**
	 * Output page
	 */
	public function page_cb() {

		// Allow user to reload extensions
		if ( isset( $_GET['wpcm-force-recheck'] ) ) {
			delete_transient( 'wpcm_extension_json' );
		}

		// Load extension json
		if ( false === ( $extension_json = get_transient( 'wpcm_extension_json' ) ) ) {

			// Extension request
			$extension_request = wp_remote_get( 'https://www.wpcarmanager.com/?never5-extensions=true' );

			if ( ! is_wp_error( $extension_request ) ) {

				// The extension json from server
				$extension_json = wp_remote_retrieve_body( $extension_request );

				// Set Transient
				set_transient( 'wpcm_extension_json', $extension_json, DAY_IN_SECONDS );
			}
		}

		?>
		<div class="wrap wpcm-extensions-wrap">
			<h2>WP Car Manager <?php _e( 'Extensions', 'wp-car-manager' ); ?> <a
					href="<?php echo add_query_arg( 'wpcm-force-recheck', '1', admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-extensions' ) ); ?>"
					class="button wpcm-reload-button">Reload Extensions</a></h2>
			<?php

			if ( false !== $extension_json ) {

				// Get all extensions
				$response = json_decode( $extension_json );

				// Display message if it's there
				if ( isset( $response->message ) && '' !== $response->message ) {
					echo '<div id="message" class="updated">' . $response->message . '</div>' . PHP_EOL;
				}

				if ( count( $response ) > 0 && isset( $response->extensions ) && count( $response->extensions ) > 0 ) {

					// Extensions
					$extensions = $response->extensions;

					// Get products
					$products = Extension\Manager::get()->get_extensions();

					// Loop through extensions
					$installed_extensions = array();

					foreach ( $extensions as $extension_key => $extension ) {
						if ( isset( $products[ $extension->product_id ] ) ) {
							$installed_extensions[] = $extension;
							unset( $extensions[ $extension_key ] );
						}
					}

					echo '<p>' . sprintf( __( 'Extend WP Car Manager with its powerful free and paid extensions. %sClick here to browse all extensions%s', 'wp-car-manager' ), '<a href="https://www.wpcarmanager.com/extensions/?utm_source=plugin&utm_medium=link&utm_campaign=extensions-top" target="_blank">', '</a>' ) . '</p>' . PHP_EOL;
					?>
					<h2 class="nav-tab-wrapper">
						<a href="#settings-available-extensions" class="nav-tab nav-tab-active">Available Extensions</a>
						<?php if ( count( $installed_extensions ) > 0 ) { ?>
							<a href="#settings-installed-extensions" class="nav-tab">Installed Extensions</a><?php } ?>
					</h2>
					<?php

					// Available Extensions
					if ( count( $extensions ) > 0 ) {

						echo '<div id="settings-available-extensions" class="settings_panel">' . PHP_EOL;
						echo '<div class="theme-browser wpcm-extensions">';

						foreach ( $extensions as $extension ) {

							$sale = false;
							if ( $extension->price > 0 ) {
								$price_display = '$' . $extension->price;
								if ( '' != $extension->sale_price && $extension->sale_price > 0 ) {
									$price_display = '<strike>$' . $extension->price . '</strike> $' . $extension->sale_price;
									$sale          = true;
								}
							} else {
								$price_display = 'FREE';
							}

							echo '<div class="theme wpcm-extension">';
							echo '<a href="' . $extension->url . '?utm_source=plugin&utm_medium=extension-block&utm_campaign=' . $extension->name . '" target="_blank">';
							echo '<div class="wpcm-extension-img-wrapper"><img src="' . $extension->image . '" alt="' . $extension->name . '" /></div>' . PHP_EOL;
							echo '<h3>' . $extension->name . '</h3>' . PHP_EOL;
							echo '<p class="wpcm-extension-desc">' . $extension->desc . '</p>';
							echo '<div class="wpcm-extension-footer">';
							echo '<span class="wpcm-extension-price' . ( ( $sale ) ? ' sale' : '' ) . '">' . $price_display . '</span>';
							echo '<span class="wpcm-extension-more">Get This Extension</span>';
							echo '</div>';
							echo '</a>';
							echo '</div>';
						}

						echo '</div>';
						echo '</div>';


					} else if ( count( $installed_extensions ) > 0 ) {
						echo '<div id="settings-available-extensions" class="settings_panel">' . PHP_EOL;
						echo '<p>Wow, looks like you installed all of our extensions. Thanks, you rock!</p>';
						echo '</div>';
					}

					// Installed Extensions
					if ( count( $installed_extensions ) > 0 ) {

						echo '<div id="settings-installed-extensions" class="settings_panel">' . PHP_EOL;

						echo '<div class="theme-browser wpcm-extensions">';
						foreach ( $installed_extensions as $extension ) {

							// Get the product
							$license = $products[ $extension->product_id ]->get_license();

							echo '<div class="theme wpcm-extension">';

							echo '<div class="wpcm-extension-img-wrapper"><img src="' . $extension->image . '" alt="' . $extension->name . '" /></div>' . PHP_EOL;
							echo '<h3>' . $extension->name . '</h3>' . PHP_EOL;

							echo '<div class="wpcm-extension-license">' . PHP_EOL;
							echo '<p class="wpcm-license-status' . ( ( $license->is_active() ) ? ' active' : '' ) . '">' . strtoupper( $license->get_status() ) . '</p>' . PHP_EOL;
							echo '<input type="hidden" id="wpcm-ajax-nonce" value="' . wp_create_nonce( 'wpcm-ajax-nonce' ) . '" />' . PHP_EOL;
							echo '<input type="hidden" id="wpcm-status" value="' . $license->get_status() . '" />' . PHP_EOL;
							echo '<input type="hidden" id="wpcm-product-id" value="' . $extension->product_id . '" />' . PHP_EOL;
							echo '<input type="text" name="wpcm-key" id="wpcm-key" value="' . $license->get_key() . '" placeholder="License Key"' . ( ( $license->is_active() ) ? ' disabled="disabled"' : '' ) . ' />' . PHP_EOL;
							echo '<input type="text" name="wpcmemail" id="wpcm-email" value="' . $license->get_email() . '" placeholder="License Email"' . ( ( $license->is_active() ) ? ' disabled="disabled"' : '' ) . ' />' . PHP_EOL;
							echo '<a href="javascript:;" class="button button-primary">' . ( ( $license->is_active() ) ? 'Deactivate' : 'Activate' ) . '</a>';
							echo '</div>' . PHP_EOL;

							echo '</div>';
						}
						echo '</div>';
						echo '</div>' . PHP_EOL;

					}

				}

			} else {
				echo '<p>' . __( "Couldn't load extensions, please try again later.", 'wp-car-manager' ) . '</p>' . PHP_EOL;
			}
			?>
		</div>
		<?php

	}

	/**
	 * AJAX license action
	 */
	public static function ajax_license_action() {

		// Check nonce
		check_ajax_referer( 'wpcm-ajax-nonce', 'nonce' );

		// Post vars
		$product_id       = sanitize_text_field( $_POST['product_id'] );
		$key              = sanitize_text_field( $_POST['key'] );
		$email            = sanitize_text_field( $_POST['email'] );
		$extension_action = $_POST['extension_action'];

		// Get extensions
		$products = Extension\Manager::get()->get_extensions();

		// Check if product exists
		if ( isset( $products[ $product_id ] ) ) {
			// Get correct product
			$product = $products[ $product_id ];
			// Set new key in license object
			$product->get_license()->set_key( $key );
			// Set new email in license object
			$product->get_license()->set_email( $email );
			if ( 'activate' === $extension_action ) {
				// Try to activate the license
				$response = $product->activate();
			} else {
				// Try to deactivate the license
				$response = $product->deactivate();
			}
		}

		// Send JSON
		wp_send_json( $response );

		// bye
		exit;
	}

}