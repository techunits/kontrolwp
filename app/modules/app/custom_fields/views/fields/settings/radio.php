<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Radio Buttons','kontrolwp')?><span class="req-ast">*</span></div>
        <div>
        	<?php if(isset($data['radio_options']) && count($data['radio_options']) > 0) { 
		           for($i=0; $i < count($data['radio_options']); $i++) {
			?>
            <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][radio_options][]" value="<?php echo $data['radio_options'][$i]?>" class="thirty required" />
                <div class="inline duplicate-parent  <?php echo ($i > 0) ? 'delete' : ''?>"></div> 
            </div>
            <?php }
             }else{ ?>
              <div class="field">
                <input type="text" name="field[<?php echo $fkey?>][settings][radio_options][]" value="" class="thirty required" />
                <div class="inline duplicate-parent"></div> 
              </div>
               <?php } ?>
        </div>
        <div class="desc"><?php echo __('Radio buttons','kontrolwp')?> <?php echo __('are entered in the following format - <b>value : label</b>. You can leave out specifying a value by just entering text into the box. The text will become the value and label in this case','kontrolwp')?>.</div>
    </div>
    
     <div class="item">
        <div class="label"><?php echo __('Default Value','kontrolwp')?></div>
        <div class="field">
            <input type="text" id="name" name="field[<?php echo $fkey?>][settings][default_value]" value="<?php echo isset($data['default_value']) ? $data['default_value']:''?>" class="sixty" />
        </div>
        <div class="desc"><?php echo __('Enter the default value for this set of radio buttons. It will be selected by default','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Style','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][radio_style]" class="sixty">
              <option value="horizontal" <?php echo isset($data['radio_style']) && $data['radio_style'] == 'horizontal' ? 'selected="selected"':''?>><?php echo __('Horizontal','kontrolwp')?></option>
              <option value="vertical" <?php echo isset($data['radio_style']) && $data['radio_style'] == 'vertical' ? 'selected="selected"':''?>><?php echo __('Vertical','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Select the style for this group of radio buttons','kontrolwp')?>.</div>
    </div>
    
</div>