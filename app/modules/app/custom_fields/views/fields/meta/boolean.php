<?
	$field_value = !empty($field_value) || !isset($field->settings['default_value']) ? $field_value : $field->settings['default_value'];
?>

<select name="_kontrol[<?=$field->field_key?>]" class="<?=$field_validation?> boolean">
     <option value="true" <?=isset($field_value) && $field_value == 'true' ? 'selected="selected"':''?>><?=__('Yes')?></option>
     <option value="false" <?=isset($field_value) && $field_value == 'false' ? 'selected="selected"':''?>><?=__('No')?></option>
 </select> &nbsp;<?=isset($field->settings['boolean_msg']) ? $field->settings['boolean_msg'] : ''; ?>
  