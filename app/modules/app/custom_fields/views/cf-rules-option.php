<?php
	$value_key = NULL;
?>

<div class="field">
		
        <div class="inline twenty rule-select">
            <select name="<?php echo $type?>[rules][param][]" class="main-rules-select custom-select" style="min-width: 200px">
               <?php $cur_opt_group = NULL;
			      $pre_opt_group = NULL;
			   ?>
               
               <?php foreach($rules as $group => $rule) { ?>
               		<optgroup label="<?php echo $group?>">
               <?php 
			   		foreach($rule as $rule_data) {
							// $data->param is the current selected rule key
							$custom_default_val = NULL;
							$rule_value = $rule_data['key'];
							
							// Check to see if it's a custom data option, they are stored eg: 'key:value'
							if(isset($rule_data['custom_select']) && isset($data->param) && strpos($data->param, ':') !== FALSE) {
								// Get the data from the current keys value eg: 'key:value'
								$custom_rule_parts = split(':', $data->param);
								$custom_rule_key = $custom_rule_parts[0];
								$custom_rule_val = $custom_rule_parts[1];
								// Set the default value for the custom select as the current value
								$custom_default_val = $custom_rule_val;
								// Set the label
								$rule_data['label'] = str_replace('%s', $custom_default_val, $rule_data['custom_select']['customLabelFormat']);
								$rule_data['key'] = $custom_rule_key;
								$rule_value = $data->param;
							}
							
							// The currently selected rule key
							$value_key = (isset($data->param) && ($rule_data['key'] == $data->param || strpos($data->param, $rule_data['key'].':') !== FALSE)) ? $rule_data['key'] : $value_key;
							
							echo $data->param;
						?>
                        	<option value="<?php echo $rule_value?>" data-show-values="<?php echo $rule_data['key']?>" <?php echo ($rule_data['key'] == $value_key) ? 'selected="selected"':'' ?> <?php if(isset($rule_data['custom_select'])) { ?> class="custom-val" confirmDefaultVal="<?php echo $custom_default_val?>" customValFormat="<?php echo $rule_data['custom_select']['customValFormat']?>"  customLabelFormat="<?php echo $rule_data['custom_select']['customLabelFormat']?>" confirmText="<?php echo $rule_data['custom_select']['confirmText']?>" <?php } ?>><?php echo $rule_data['label']?>&nbsp;</option>
                        <?php 
					}
			   
			  	?>
               		</optgroup>
               <?php }?>
                  
           </select>
               
              
       </div>
        <div class="inline twenty">
            <select name="<?php echo $type?>[rules][operator][]" style="width: 120px">
               <option value="=" <?php echo (isset($data->operator) && $data->operator == '=') ? 'selected="selected"':'' ?>><?php echo __('equals','kontrolwp')?></option>
               <option value="!=" <?php echo (isset($data->operator) && $data->operator == '!=') ? 'selected="selected"':'' ?>><?php echo __('does not equal','kontrolwp')?></option>
               <option value="%value%" <?php echo (isset($data->operator) && $data->operator == '%value%') ? 'selected="selected"':'' ?>><?php echo __('contains','kontrolwp')?></option>
               <option value="value%" <?php echo (isset($data->operator) && $data->operator == 'value%') ? 'selected="selected"':'' ?>><?php echo __('begins with','kontrolwp')?></option>
               <option value="%value" <?php echo (isset($data->operator) && $data->operator == '%value') ? 'selected="selected"':'' ?>><?php echo __('ends with','kontrolwp')?></option>
               
           </select>
       </div>
        <div class="inline twenty">
            <?php 
            $count = 0;
			foreach($rules as $group => $group_rules) { 
				foreach($group_rules as $rule) {
					
					$rule_key = $rule['key']; 
					$rule_data = $rule['data']; 
					
										
					// Determine which rule value set to show
					if($value_key == $rule_key) {
						$show = TRUE;	
					}else{
						$show = FALSE;	
					}
					// Show the first one if we don't have any presaved rules
					if($show == FALSE && empty($value_key) && empty($count)) {
						$show = TRUE;	
					}
					
					
					
				?>
				  <div class="rule-val <?php echo str_replace(':','_',$rule_key)?> <?php echo $show == FALSE ? 'hide':''?>">
					 <?php if(isset($rule['data_type']) && $rule['data_type'] == 'select') { ?>
							  <select name="<?php echo $type?>[rules][value][]" <?php echo $show == FALSE ? 'disabled="disabled"':''?> style="min-width: 220px;" >
							  <?php foreach($rule['data'] as $value => $label) { ?>
								  <?php if(isset($label['values']) && is_array($label['values'])) { ?>
									<optgroup label="<?php echo $value?>">
										<?php foreach($label['values'] as $subvalue => $sublabel) { ?>
											 <option value="<?php echo esc_attr($subvalue)?>" <?php echo (isset($data->value) && $data->value == esc_attr($subvalue)) ? 'selected="selected"':'' ?>>&nbsp;&nbsp;<?php echo $sublabel?></option>
										<?php } ?>
									</optgroup>
								  <?php }else{ ?>
								  <option value="<?php echo esc_attr($value)?>" <?php echo (isset($data->value) && $data->value == esc_attr($value)) ? 'selected="selected"':'' ?>><?php echo $label?></option>
								  <?php } ?>
							  <?php } ?>
							  </select>
						<?php } ?>
						<?php if(isset($rule['data_type']) && $rule['data_type'] == 'text') { 		
						?>
							<input type="text" name="<?php echo $type?>[rules][value][]" value="<?php echo (isset($data->value) && strlen($data->value) > 0 && $show == TRUE) ? esc_attr($data->value) : ''?>" class="required" placeholder="<?php echo __('Enter field value','kontrolwp')?>" style="min-width: 220px;" />
						<?php } ?>
					  </div>
				<?php $count++;
				}
			} ?>
    
       </div>
       <div class="inline duplicate-parent <?php echo !empty($index) ? 'delete' : ''?>" data-dont-reset-select="true"></div>
</div>