<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>
<div class="wrap nosubsub wpcm-page-makes">
	<h2><?php echo $title; ?></h2>

	<div id="col-container">
		<div id="col-right">
			<div class="col-wrap">
				<table class="wp-list-table widefat fixed striped tags">
					<thead>
					<tr>
						<th scope="col" id="name" class="manage-column sortable column-name desc">
							<span><?php _e( 'Name' ); ?></span></th>
						<th scope="col" id="slug" class="manage-column column-slug desc">
							<span><?php _e( 'Slug' ); ?></span></th>
					</tr>
					</thead>

					<tbody id="the-list" data-wp-lists="list:tag">
					<?php if ( count( $items ) > 0 ): ?>
						<?php foreach ( $items as $item ): ?>
							<tr>
								<td class="name column-name">
									<strong><a class="row-title" href="<?php echo add_query_arg( array(
											'make' => absint( $_GET['make'] ),
											'edit' => $item['id']
										), admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-makes' ) ); ?>"><?php echo $item['name']; ?></a></strong>
									<br>

									<div class="row-actions">
										<span class="edit">
											<a href="<?php echo add_query_arg( array(
												'make' => absint( $_GET['make'] ),
												'edit' => $item['id']
											), admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-makes' ) ); ?>">Edit</a> |
										</span>
										<span class="delete">
											<a class="delete-tag" href="<?php echo add_query_arg( array(
												'make'       => absint( $_GET['make'] ),
												'action'     => 'delete',
												'term_id'    => $item['id'],
												'wpcm_nonce' => wp_create_nonce( 'wpcm_make_nonce_wow_much_security' )
											), admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-makes' ) ); ?>">Delete</a>
										</span>
									</div>
								</td>
								<td class="slug column-slug"><?php echo $item['slug']; ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr class="no-items">
							<td class="colspanchange" colspan="2"><?php _e( 'No Models found', 'wp-car-manager' ); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>

					<tfoot>
					<tr>
						<th scope="col" class="manage-column sortable column-name desc">
							<span><?php _e( 'Name' ); ?></span></th>
						<th scope="col" class="manage-column column-slug desc"><span><?php _e( 'Slug' ); ?></span></th>
					</tr>
					</tfoot>

				</table>
			</div>
		</div>
		<div id="col-left">
			<div class="col-wrap">

				<div class="wpcm-models-explanation">
					<h2><?php _e( 'What are Models?', 'wp-car-manager' ); ?></h2>
					<p><?php _e( "On this page you manage your vehicles models. You can add a new model with the form below and manage your existing models on the right. A model is always linked to one make.", 'wp-car-manager' ); ?></p>
					<p><a href="https://www.wpcarmanager.com/kb/makes-models/?utm_source=plugin&utm_medium=link&utm_campaign=models" target="_blank"><?php _e( 'You can read more about Makes and Models here', 'wp-car-manager' ); ?></a></p>
				</div>
				
				<div class="form-wrap">
					<h2><?php _e( 'Add New Model', 'wp-car-manager' ); ?></h2>

					<form id="add-make" method="post"
					      action="<?php echo esc_url( admin_url( 'edit.php?post_type=wpcm_vehicle&page=wpcm-makes&make=' . $_GET['make'] ) ) ?>">

						<?php wp_nonce_field( 'wpcm_make_nonce_wow_much_security', 'wpcm_make_nonce' ); ?>

						<input type="hidden" name="wpcm_action" value="add_term"/>

						<input type="hidden" name="make_id" value="<?php echo $_GET['make']; ?>"/>

						<div class="form-field form-required term-name-wrap">
							<label for="tag-name"><?php _e( 'Name' ); ?></label>
							<input name="name" id="tag-name" type="text" value="" size="40" aria-required="true">

							<p><?php _e( 'The name is how it appears on your site.' ); ?></p>
						</div>
						<div class="form-field term-slug-wrap">
							<label for="tag-slug"><?php _e( 'Slug' ); ?></label>
							<input name="slug" id="tag-slug" type="text" value="" size="40">

							<p><?php _e( 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.' ); ?></p>
						</div>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
						                         value="<?php _e( 'Add New Model', 'wp-car-manager' ); ?>"></p>
					</form>

				</div>
			</div>

		</div>
	</div>
</div>