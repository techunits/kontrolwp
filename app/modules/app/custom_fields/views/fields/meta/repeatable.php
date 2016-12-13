<div class="kontrol-smart-box" data-auto-add-row="true">

    <div class="section">
        <div class="inside">
		      	
<?php

  // Display all the sub fields
  if(isset($sub_fields) && is_array($sub_fields) && count($sub_fields) > 0) 
  { 
  		if($field->settings['repeat_row_style'] == 'horizontal') {
			$field_width = round(87/count($sub_fields), 4);
			$field_padding_perc = round(3/count($sub_fields), 4);
		}else{
			$field_width = 94;
			$field_padding_perc = 0;
		}
		$rows_data = array();
		$row_count = 0;
		
		?>
        	<div class="title <?php echo $field->settings['repeat_row_style'] == 'vertical' ? 'hide' : ''?>">
				<?php foreach($sub_fields as $sub_field) { 
					$sub_field->settings = unserialize($sub_field->settings); 
					$sub_field->validation = unserialize($sub_field->validation); 
					// Make the field key an array of it's parent
					$sub_field->field_key_orig = $sub_field->field_key;
					$sub_field->field_key = $field->field_key.'][kontrol_row_id]['.$sub_field->field_key_orig;
					
					if($field->settings['repeat_row_style'] == 'horizontal') {
				?>
                    	<div  class="inline" style="width: <?php echo $field_width?>%; padding-left: <?php echo $field_padding_perc?>%;">
							<div class="field-name title" data-copy="<?php echo $sub_field->field_key_orig?>"><?php echo $sub_field->name?> <?php echo (isset($sub_field->validation) && in_array('required', $sub_field->validation)) ? '<span class="req-ast">*</span>' : ''?>
                            	<?php if(isset($sub_field->settings['tip']['enabled']) && $sub_field->settings['tip']['enabled'] == TRUE) { ?>
                                        &nbsp;<div class="inline kontrol-tip tip-small" 
                                             title="<?php echo htmlentities($sub_field->settings['tip']['title'], ENT_QUOTES, 'UTF-8')?>" 
                                             data-text="<?php echo htmlentities($sub_field->settings['tip']['text'], ENT_QUOTES, 'UTF-8')?>"
                                             data-width="<?php echo htmlentities($sub_field->settings['tip']['width'], ENT_QUOTES, 'UTF-8')?>"></div>
                                   <?php } ?>
                            </div> 
                        	<div class="instructions"><?php echo $sub_field->instructions?></div>
                        </div>
				<?php 	} 
				} ?>
            </div>
            
            <div class="rows sortable">
            	<div class="row new-row <?php echo $field->settings['repeat_row_style'] == 'vertical' ? 'vertical' : ''?>">
                        <div class="inline tab drag-row"></div>
                        <?php // Now print out our rows
                        foreach($sub_fields as $sub_field) {
                            // Check it has validation first
                            if(is_array($sub_field->validation)) {
                                $field_validation = implode(' ',$sub_field->validation);	
                            }
							
                            $sub_field->field_key = $field->field_key.'][kontrol_row_id]['.$sub_field->field_key_orig;
							$sub_field_value = isset($sub_field_values[$sub_field->field_key_orig]) ? $sub_field_values[$sub_field->field_key_orig] : NULL;
                        ?>
                        	<?php if($field->settings['repeat_row_style'] == 'vertical') { ?>
                            	<div class="details">
                                    <div class="title" data-copy="<?php echo $sub_field->field_key_orig?>"><?php echo $sub_field->name?> <?php echo (isset($sub_field->validation) && in_array('required', $sub_field->validation)) ? '<span class="req-ast">*</span>' : ''?>
                                    	<?php if(isset($sub_field->settings['tip']['enabled']) && $sub_field->settings['tip']['enabled'] == TRUE) { ?>
                                        &nbsp;<div class="inline kontrol-tip tip-small" 
                                             title="<?php echo htmlentities($sub_field->settings['tip']['title'], ENT_QUOTES, 'UTF-8')?>" 
                                             data-text="<?php echo htmlentities($sub_field->settings['tip']['text'], ENT_QUOTES, 'UTF-8')?>"
                                             data-width="<?php echo htmlentities($sub_field->settings['tip']['width'], ENT_QUOTES, 'UTF-8')?>"></div>
                                   		<?php } ?>
                                    </div> 
                                    <div class="instructions"><?php echo $sub_field->instructions?></div>
                                </div>
                            <?php } ?>
                           		<div class="field <?php echo $field->settings['repeat_row_style'] == 'horizontal' ? 'inline' : 'vertical'?>" style="width: <?php echo $field_width?>%; padding-left: <?php echo $field_padding_perc?>%;"><?php echo $this->renderElement('fields/meta/'.$sub_field->field_type, array('current_user' => $current_user, 'field' => $sub_field, 'field_validation' => $field_validation.' do-not-enable', 'field_value' => NULL, 'post' => $post));?></div>	   
                         <?php } ?>
                        <div class="delete-row" title="<?php echo __('Delete Row', 'kontrolwp')?>"></div>
            		</div>  
                
         		<?php if(is_array($field_value) && count($field_value) > 0) { 
				
					$row_count = 0;
					foreach($field_value as $sub_field_values) { 
				?>
                    <div class="row <?php echo $field->settings['repeat_row_style'] == 'vertical' ? 'vertical' : ''?>">
                        <div class="inline tab drag-row"></div>
                        <?php // Now print out our rows
                        foreach($sub_fields as $sub_field) {
                            // Check it has validation first
                            if(is_array($sub_field->validation)) {
                                $field_validation = implode(' ',$sub_field->validation);	
                            }
							
                            $sub_field->field_key = $field->field_key.']['.$row_count.']['.$sub_field->field_key_orig;
							$sub_field_value = isset($sub_field_values[$sub_field->field_key_orig]) ? $sub_field_values[$sub_field->field_key_orig] : NULL;
                        ?>
                        	<?php if($field->settings['repeat_row_style'] == 'vertical') { ?>
                            	<div class="details">
                                    <div class="title" data-copy="<?php echo $sub_field->field_key_orig?>"><?php echo $sub_field->name?> <?php echo (isset($sub_field->validation) && in_array('required', $sub_field->validation)) ? '<span class="req-ast">*</span>' : ''?>
                                    	<?php if(isset($sub_field->settings['tip']['enabled']) && $sub_field->settings['tip']['enabled'] == TRUE) { ?>
                                        &nbsp;<div class="inline kontrol-tip tip-small" 
                                             title="<?php echo htmlentities($sub_field->settings['tip']['title'], ENT_QUOTES, 'UTF-8')?>" 
                                             data-text="<?php echo htmlentities($sub_field->settings['tip']['text'], ENT_QUOTES, 'UTF-8')?>"
                                             data-width="<?php echo htmlentities($sub_field->settings['tip']['width'], ENT_QUOTES, 'UTF-8')?>"></div>
                                   		<?php } ?>
                                    </div>
                                    <div class="instructions"><?php echo $sub_field->instructions?></div>
                                </div>
                            <?php } ?>
                           		<div class="field <?php echo $field->settings['repeat_row_style'] == 'horizontal' ? 'inline' : 'vertical'?>" style="width: <?php echo $field_width?>%; padding-left: <?php echo $field_padding_perc?>%;"><?php echo $this->renderElement('fields/meta/'.$sub_field->field_type, array('current_user' => $current_user, 'field' => $sub_field, 'field_validation' => $field_validation, 'field_value' => $sub_field_value, 'post' => $post));?></div>	   
                         <?php } ?>
                        <div class="delete-row" title="<?php echo __('Delete Row', 'kontrolwp')?>"></div>
            		</div>  
                <?php    	$row_count++;
						}
				    } ?> 
           
           </div>
        <?php  
 } ?>
 

        <div class="add-row" data-max-rows="<?php echo !empty($field->settings['repeat_row_limit']) ? $field->settings['repeat_row_limit']:0 ?>"><a class="button-primary">+ <?php echo __('Add Row', 'kontrolwp')?></a></div>
        </div>
    </div>

</div>