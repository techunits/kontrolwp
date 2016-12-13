 
 <?php 
 $index = 0;
 foreach($field->settings['checkbox_options'] as $checkbox) { 
 		$validators = split(' ', $field_validation);
 		if(in_array('required', $validators)) {
				$field_validation .= ' validate-one-required ';
		}
		$checked = FALSE;
		$parts = split(':', $checkbox);
		$value = $parts[0];
		$label = trim(isset($parts[1]) && !empty($parts[1]) ? $parts[1] : $parts[0]);
		// Select if it need too
		if(is_array($field_value) && in_array($value, $field_value)) { $checked = TRUE; }
	?>
    	<input type="checkbox" 
        	name="_kontrol[<?php echo $field->field_key?>][]" 
			<?php echo $index == 0 && isset($field->settings['checkbox_max_values']) && !empty($field->settings['checkbox_max_values']) ? 'data-max-val="'.$field->settings['checkbox_max_values'].'"' : ''?> 
        	value="<?php echo $value?>" 
            title="<?php echo $index == 0 ? __('Please select at least one checkbox.','kontrolwp'):''?>" 
			<?php echo $checked ? 'checked="checked"':''?> 
			<?php echo $index == 0 ? 'class="'.$field_validation.' msgPos:\''.$field->field_key.'-checkbox-advice\'"':''?> 
             /> 
			<?php echo $label?> &nbsp;&nbsp;
        <?php if($field->settings['checkbox_style'] == 'vertical') { ?>
       		 <div class="checkbox-div"></div>
        <?php } ?>
    <?php
	$index++;
} ?>

<div id="<?php echo $field->field_key?>-checkbox-advice"></div>

  