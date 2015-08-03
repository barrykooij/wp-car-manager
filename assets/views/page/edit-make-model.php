<div class="wrap wpcm-page-edit-make">
	<h2><?php echo $title; ?></h2>

	<form method="post" action="<?php echo $form_action; ?>">
		<?php wp_nonce_field( 'wpcm_make_nonce_wow_much_security', 'wpcm_make_nonce' ); ?>
		<input type="hidden" name="term_id" value="<?php echo $item['id']; ?>"/>

		<?php if ( isset( $_GET['make'] ) ): ?>
			<input type="hidden" name="make_id" value="<?php echo absint( $_GET['make'] ); ?>"/>
		<?php endif; ?>

		<input type="hidden" name="wpcm_action" value="edit_term"/>
		<table class="form-table">
			<tbody>
			<tr class="form-field form-required term-name-wrap">
				<th scope="row"><label for="name"><?php _e( 'Name' ); ?></label></th>
				<td>
					<input name="name" id="name" type="text" value="<?php echo $item['name']; ?>" size="40" aria-required="true">
					<p class="description"><?php _e( 'The name is how it appears on your site.' ); ?></p>
				</td>
			</tr>
			<tr class="form-field term-slug-wrap">
				<th scope="row"><label for="slug"><?php _( 'Slug' ); ?></label></th>
				<td>
					<input name="slug" id="slug" type="text" value="<?php echo $item['slug']; ?>" size="40">
					<p class="description"><?php _e( 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.' ); ?></p>
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Update' ); ?>">
		</p>
	</form>
</div>