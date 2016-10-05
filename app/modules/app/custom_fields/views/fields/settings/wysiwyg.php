<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Allow Media Buttons?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][allow_media_buttons]" class="sixty">
              <option value="false" <?php echo isset($data['allow_media_buttons']) && $data['allow_media_buttons'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
              <option value="true" <?php echo isset($data['allow_media_buttons']) && $data['allow_media_buttons'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Media buttons such as insert/upload button can be turned off','kontrolwp')?>.</div>
    </div>
   <div class="item">
        <div class="label"><?php echo __('Default Value','kontrolwp')?></div>
        <div class="field">
            <textarea name="field[<?php echo $fkey?>][settings][default_value]" class="sixty"><?php echo isset($data['default_value']) ? $data['default_value']:''?></textarea>
        </div>
        <div class="desc"><?php echo __('Enter the default value for this wysiwyg text area','kontrolwp')?>.</div>
    </div>
</div>