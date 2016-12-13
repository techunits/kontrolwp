 
 <?php 
 $index = 0;
 foreach($field->settings['radio_options'] as $checkbox) { 
 		$validators = split(' ', $field_validation);
 		if(in_array('required', $validators)) {
				$field_validation .= ' validate-one-required ';
		}
		$checked = FALSE;
		$parts = split(':', $checkbox);
		$value = $parts[0];
		$label = trim(isset($parts[1]) && !empty($parts[1]) ? $parts[1] : $parts[0]);
		// FIeld value
		$field_value = !empty($field_value) ? $field_value : $field->settings['default_value'];
		// Select if it need too
		if($value == $field_value) { $checked = TRUE; }
	?>
    	<input type="radio" 
        	name="_kontrol[<?php echo $field->field_key?>]" 
			value="<?php echo $value?>" 
			<?php echo $checked ? 'checked="checked"':''?> 
			<?php echo $index == 0 ? 'class="'.$field_validation.' msgPos:\''.$field->field_key.'-radio-advice\'"':''?> 
             /> 
			<?php echo $label?> &nbsp;&nbsp;
        <?php if($field->settings['radio_style'] == 'vertical') { ?>
       		 <div class="radio-div"></div>
       <?php } ?>
    <?php
	$index++;
} ?>

<div id="<?php echo $field->field_key?>-radio-advice"></div>

  