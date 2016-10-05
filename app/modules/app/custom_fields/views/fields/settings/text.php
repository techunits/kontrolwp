<div class="field-<?php echo $type?> field-settings">
    <div class="item">
        <div class="label"><?php echo __('Allow HTML','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][allow_html]" class="sixty">
              <option value="false" <?php echo isset($data['allow_html']) && $data['allow_html'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
              <option value="true" <?php echo isset($data['allow_html']) && $data['allow_html'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Allow HTML tags to be entered in this text field?','kontrolwp')?></div>
    </div>
     <div class="item">
        <div class="label"><?php echo __('Default Value','kontrolwp')?></div>
        <div class="field">
             <input type="text" id="name" name="field[<?php echo $fkey?>][settings][default_value]" value="<?php echo isset($data['default_value']) ? htmlentities($data['default_value'], ENT_QUOTES, 'UTF-8'):''?>" class="sixty" />
        </div>
        <div class="desc"><?php echo __('Enter the default value for this text field','kontrolwp')?>.</div>
    </div>
</div>