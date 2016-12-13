<?php
	$field_value = !empty($field_value) || !isset($field->settings['default_value']) ? $field_value : $field->settings['default_value'];
?>

<select name="_kontrol[<?php echo $field->field_key?>]" class="<?php echo $field_validation?> boolean">
     <option value="true" <?php echo isset($field_value) && $field_value == 'true' ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
     <option value="false" <?php echo isset($field_value) && $field_value == 'false' ? 'selected="selected"':''?>><?php echo __('No')?></option>
 </select> &nbsp;<?php echo isset($field->settings['boolean_msg']) ? $field->settings['boolean_msg'] : ''; ?>
  