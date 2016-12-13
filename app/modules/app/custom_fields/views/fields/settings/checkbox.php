<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Checkbox Options','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
        	<?php if(isset($data['checkbox_options']) && count($data['checkbox_options']) > 0) { 
		           for($i=0; $i < count($data['checkbox_options']); $i++) {
			?>
            <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][checkbox_options][]" value="<?php echo $data['checkbox_options'][$i]?>" class="thirty required" />
                <div class="inline duplicate-parent  <?php echo ($i > 0) ? 'delete' : ''?>"></div> 
            </div>
            <?php }
             }else{ ?>
              <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][checkbox_options][]" value="" class="thirty required" />
                <div class="inline duplicate-parent"></div> 
              </div>
               <?php } ?>
        </div>
        <div class="desc"><?php echo __('Checkboxes','kontrolwp')?> <?php echo __('are entered in the following format - <b>value : label</b>. You can leave out specifying a value by just entering text into the box. The text will become the value and label in this case','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Maximum Selected Checkboxes Allowed','kontrolwp')?></div>
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][checkbox_max_values]" value="<?php echo isset($data['checkbox_max_values']) ? $data['checkbox_max_values']:''?>" class="thirty validate-integer" />
        </div>
        <div class="desc"><?php echo __('Enter a number to limit the number of checkboxes from this group that the user is allowed to check','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Style','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][checkbox_style]" class="sixty">
              <option value="horizontal" <?php echo isset($data['checkbox_style']) && $data['checkbox_style'] == 'horizontal' ? 'selected="selected"':''?>><?php echo __('Horizontal','kontrolwp')?></option>
              <option value="vertical" <?php echo isset($data['checkbox_style']) && $data['checkbox_style'] == 'vertical' ? 'selected="selected"':''?>><?php echo __('Vertical','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Select the style for this group of checkboxes','kontrolwp')?>.</div>
    </div>
    
    
</div>