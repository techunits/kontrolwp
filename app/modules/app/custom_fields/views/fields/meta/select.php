 <?
 $index = 0;
 $multi_select = FALSE; 
 // Get the values
 $select_vals = isset($field_value) && is_array($field_value) ? $field_value : array($field_value);
 $select_row_vals = array();
 // Mutliple select box
 if(isset($field->settings['select_max_values']) && is_numeric($field->settings['select_max_values']) && $field->settings['select_max_values'] > 1) {
	 $multi_select = TRUE;
 }
	
 ?>
 
 <select <?=!$multi_select ? 'name="_kontrol['.$field->field_key.']"':''?> class="<?=$field_validation?>" <?=$multi_select ? 'multiple="multiple" data-smart-box="true" data-max-val="'.$field->settings['select_max_values'].'"':''?>>
 	<? foreach($field->settings['select_options'] as $option) { 
			$selected = FALSE;
			$parts = split(':', $option);
			$value = $parts[0];
			$label = trim(isset($parts[1]) && !empty($parts[1]) ? $parts[1] : $parts[0]);
			// Select if it need too
			if(in_array($value, $select_vals)) { $selected = TRUE; }
			
			if($selected) {
					$select_row_vals[$value] = array('label'=>$label, 'value'=>$value);
			}
			
			if($field->settings['select_null'] == TRUE && $index == 0) {
				
	?>
    			<option value="" <?=$selected ? 'selected="selected"':''?>><?=__('Select')?></option>
    <? 		} ?>
    	<option value="<?=$value?>" <?=$selected ? 'selected="selected"':''?>><?=$label?></option>
    <? $index++;
	} ?>
 </select>
 

  <? if($multi_select) { ?>
  
  	<? // In here so that the values can be reset if nothing is selected ?> 
 	<input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="" />
    
	<div class="kontrol-smart-box" data-hide-when-empty="true" data-disable-row-delete="true">
      <div class="section">
          <div class="inside">
               <div class="rows sortable">
               	  <div class="row new-row">
                      <div class="inline tab drag-row"></div>
                      <div class="content inline">[[LABEL]]</div>
                      <div class="delete-row" title="<?=__('Delete Row', 'kontrolwp')?>"></div>  
                      <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="[[VALUE]]" />
                   </div>
               	  <? foreach($select_vals as $value) { 
						
						$data = isset($select_row_vals[$value]) ? $select_row_vals[$value] : '';
						if(!empty($data)) { 
				  ?>
                          <div class="row">
                              <div class="inline tab drag-row"></div>
                              <div class="content inline"><?=$data['label']?></div>
                              <div class="delete-row" title="<?=__('Delete Row', 'kontrolwp')?>"></div>  
                              <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="<?=$data['value']?>" />
                           </div>
                   <? 	}
				   } ?>
               </div> 
          </div>
      </div> 
   </div>   
<? } ?>