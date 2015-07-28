<label for="<?php echo $field['key']; ?>">
	<span><?php echo $field['label']; ?></span>
	<input type="text" name="<?php echo $mb_prefix; ?>[<?php echo $field['key']; ?>]" id="<?php echo $field['key']; ?>"
	       value="<?php echo $field['value']; ?>"/>
</label>