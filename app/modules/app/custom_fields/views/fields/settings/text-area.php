<div class="field-<?php echo $type?> field-settings">
    <div class="item">
        <div class="label"><?php echo __('Allow HTML','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][allow_html]" class="sixty">
              <option value="false" <?php echo isset($data['allow_html']) && $data['allow_html'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
              <option value="true" <?php echo isset($data['allow_html']) && $data['allow_html'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Allow HTML tags to be entered in this text area?','kontrolwp')?></div>
    </div>
    <div class="item">
        <div class="label">Automatically convert line breaks to &lt;br /&gt; tags?<span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][br_convert]" class="sixty">
              <option value="true" <?php echo isset($data['br_convert']) && $data['br_convert'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
              <option value="false" <?php echo isset($data['br_convert']) && $data['br_convert'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Allow HTML tags to be entered in this text area?')?></div>
    </div>
     <div class="item">
        <div class="label"><?php echo __('Default Value','kontrolwp')?></div>
        <div class="field">
            <textarea name="field[<?php echo $fkey?>][settings][default_value]" class="sixty"><?php echo isset($data['default_value']) ? $data['default_value']:''?></textarea>
        </div>
        <div class="desc"><?php echo __('Enter the default value for this text area','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Textarea Height','kontrolwp')?></div>
        <div class="field">
            <input type="text" id="name" name="field[<?php echo $fkey?>][settings][height]" value="<?php echo isset($data['height']) ? htmlentities($data['height'], ENT_QUOTES, 'UTF-8'):''?>" class="validate-integer sixty" />
        </div>
        <div class="desc"><?php echo __('Enter the height of the textarea in pixels. Leave blank for the default height','kontrolwp')?>.</div>
    </div>
</div>