<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('Allow Media Buttons?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][allow_media_buttons]" class="sixty">
              <option value="false" <?=isset($data['allow_media_buttons']) && $data['allow_media_buttons'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
              <option value="true" <?=isset($data['allow_media_buttons']) && $data['allow_media_buttons'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('Media buttons such as insert/upload button can be turned off','kontrolwp')?>.</div>
    </div>
   <div class="item">
        <div class="label"><?=__('Default Value','kontrolwp')?></div>
        <div class="field">
            <textarea name="field[<?=$fkey?>][settings][default_value]" class="sixty"><?=isset($data['default_value']) ? $data['default_value']:''?></textarea>
        </div>
        <div class="desc"><?=__('Enter the default value for this wysiwyg text area','kontrolwp')?>.</div>
    </div>
</div>