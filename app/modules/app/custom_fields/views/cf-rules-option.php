<?
	$value_key = NULL;
?>

<div class="field">
		
        <div class="inline twenty rule-select">
            <select name="<?=$type?>[rules][param][]" class="main-rules-select custom-select" style="min-width: 200px">
               <? $cur_opt_group = NULL;
			      $pre_opt_group = NULL;
			   ?>
               
               <? foreach($rules as $group => $rule) { ?>
               		<optgroup label="<?=$group?>">
               <? 
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
                        	<option value="<?=$rule_value?>" data-show-values="<?=$rule_data['key']?>" <?=($rule_data['key'] == $value_key) ? 'selected="selected"':'' ?> <? if(isset($rule_data['custom_select'])) { ?> class="custom-val" confirmDefaultVal="<?=$custom_default_val?>" customValFormat="<?=$rule_data['custom_select']['customValFormat']?>"  customLabelFormat="<?=$rule_data['custom_select']['customLabelFormat']?>" confirmText="<?=$rule_data['custom_select']['confirmText']?>" <? } ?>><?=$rule_data['label']?>&nbsp;</option>
                        <? 
					}
			   
			  	?>
               		</optgroup>
               <? }?>
                  
           </select>
               
              
       </div>
        <div class="inline twenty">
            <select name="<?=$type?>[rules][operator][]" style="width: 120px">
               <option value="=" <?=(isset($data->operator) && $data->operator == '=') ? 'selected="selected"':'' ?>><?=__('equals','kontrolwp')?></option>
               <option value="!=" <?=(isset($data->operator) && $data->operator == '!=') ? 'selected="selected"':'' ?>><?=__('does not equal','kontrolwp')?></option>
               <option value="%value%" <?=(isset($data->operator) && $data->operator == '%value%') ? 'selected="selected"':'' ?>><?=__('contains','kontrolwp')?></option>
               <option value="value%" <?=(isset($data->operator) && $data->operator == 'value%') ? 'selected="selected"':'' ?>><?=__('begins with','kontrolwp')?></option>
               <option value="%value" <?=(isset($data->operator) && $data->operator == '%value') ? 'selected="selected"':'' ?>><?=__('ends with','kontrolwp')?></option>
               
           </select>
       </div>
        <div class="inline twenty">
            <? 
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
				  <div class="rule-val <?=str_replace(':','_',$rule_key)?> <?=$show == FALSE ? 'hide':''?>">
					 <? if(isset($rule['data_type']) && $rule['data_type'] == 'select') { ?>
							  <select name="<?=$type?>[rules][value][]" <?=$show == FALSE ? 'disabled="disabled"':''?> style="min-width: 220px;" >
							  <? foreach($rule['data'] as $value => $label) { ?>
								  <? if(isset($label['values']) && is_array($label['values'])) { ?>
									<optgroup label="<?=$value?>">
										<? foreach($label['values'] as $subvalue => $sublabel) { ?>
											 <option value="<?=esc_attr($subvalue)?>" <?=(isset($data->value) && $data->value == esc_attr($subvalue)) ? 'selected="selected"':'' ?>>&nbsp;&nbsp;<?=$sublabel?></option>
										<? } ?>
									</optgroup>
								  <? }else{ ?>
								  <option value="<?=esc_attr($value)?>" <?=(isset($data->value) && $data->value == esc_attr($value)) ? 'selected="selected"':'' ?>><?=$label?></option>
								  <? } ?>
							  <? } ?>
							  </select>
						<? } ?>
						<? if(isset($rule['data_type']) && $rule['data_type'] == 'text') { 		
						?>
							<input type="text" name="<?=$type?>[rules][value][]" value="<?=(isset($data->value) && strlen($data->value) > 0 && $show == TRUE) ? esc_attr($data->value) : ''?>" class="required" placeholder="<?=__('Enter field value','kontrolwp')?>" style="min-width: 220px;" />
						<? } ?>
					  </div>
				<? $count++;
				}
			} ?>
    
       </div>
       <div class="inline duplicate-parent <?=!empty($index) ? 'delete' : ''?>" data-dont-reset-select="true"></div>
</div>