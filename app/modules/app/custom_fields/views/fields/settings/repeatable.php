<div class="field-<?php echo $type?> field-settings">
	<!-- Sub Fields -->
    <div class="repeatable-fields">
         <!-- Fields -->
        <?php
        $field_list = isset($field_data->fields) ? $field_data->fields : NULL; 
		$this->renderElement('cf-fields', array('title'=>'Repeatable Fields', 'field_list'=>$field_list, 'field_types'=>$field_types, 'rules'=>$rules, 'field_type'=>$field_type)); 
		?>
    </div>
    <!-- End Sub Fields -->
	<div class="item">
        <div class="label"><?php echo __('Row Limit','kontrolwp')?></div>
        <div class="field">  
            <input type="text" name="field[<?php echo $fkey?>][settings][repeat_row_limit]" value="<?php echo isset($data['repeat_row_limit']) ? $data['repeat_row_limit']:""?>" class="validate-integer sixty" />
        </div>
        <div class="desc"><?php echo __('Enter a number here to limit the possible number of rows the user can create','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Row Style','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][repeat_row_style]" class="sixty">
              <option value="horizontal" <?php echo isset($data['repeat_row_style']) && $data['repeat_row_style'] == 'horizontal' ? 'selected="selected"':''?>><?php echo __('Horizontal','kontrolwp')?></option>
              <option value="vertical" <?php echo isset($data['repeat_row_style']) && $data['repeat_row_style'] == 'vertical' ? 'selected="selected"':''?>><?php echo __('Vertical','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Horizontal will set the fields in a row to appear besides each other. Vertical will make them appear below each other','kontrolwp')?>.</div>
    </div>
   
    
</div>