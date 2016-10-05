<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Default Option','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][default_value]" class="sixty custom-select">
                <option value="false" <?php echo isset($data['default_value']) && $data['default_value'] == false ? 'selected="selected"':''?>>No</option>
                <option value="true" <?php echo isset($data['default_value']) && $data['default_value'] == true ? 'selected="selected"':''?>>Yes</option>
            </select>
        </div>
        <div class="desc"><?php echo __('Select the default option','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Message','kontrolwp')?></div>
        <div class="field">
            <input type="text" id="name" name="field[<?php echo $fkey?>][settings][boolean_msg]" value="<?php echo isset($data['boolean_msg']) ? $data['boolean_msg']:''?>" class="sixty" />
        </div>
        <div class="desc"><?php echo __('Enter an optional message/question to appear beside the true/false select box','kontrolwp')?>.</div>
    </div>
</div>