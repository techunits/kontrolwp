<div class="field-<?=$type?> field-settings">
    <div class="item">
        <div class="label"><?=__('Allow HTML','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][allow_html]" class="sixty">
              <option value="false" <?=isset($data['allow_html']) && $data['allow_html'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
              <option value="true" <?=isset($data['allow_html']) && $data['allow_html'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('Allow HTML tags to be entered in this text field?','kontrolwp')?></div>
    </div>
     <div class="item">
        <div class="label"><?=__('Default Value','kontrolwp')?></div>
        <div class="field">
             <input type="text" id="name" name="field[<?=$fkey?>][settings][default_value]" value="<?=isset($data['default_value']) ? htmlentities($data['default_value'], ENT_QUOTES, 'UTF-8'):''?>" class="sixty" />
        </div>
        <div class="desc"><?=__('Enter the default value for this text field','kontrolwp')?>.</div>
    </div>
</div>