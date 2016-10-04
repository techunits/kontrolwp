<div class="field-<?=$type?> field-settings">
    <div class="item">
        <div class="label"><?=__('Return Type','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][return_type]" class="sixty">
              <option value="url_absolute" <?=isset($data['return_type']) && $data['return_type'] == 'url_absolute' ? 'selected="selected"':''?>><?=__('Adaptable URL','kontrolwp')?></option>
              <option value="url" <?=isset($data['return_type']) && $data['return_type'] == 'url' ? 'selected="selected"':''?>><?=__('Static URL','kontrolwp')?></option>
              <option value="post_object" <?=isset($data['return_type']) && $data['return_type'] == 'post_object' ? 'selected="selected"':''?>><?=__('Attachment Object','kontrolwp')?></option>
            </select>  
            <div class="inline kontrol-tip" title="<?=__('Return Type','kontrolwp')?>" data-width="450" data-text="<?=htmlentities(__('<b>Adaptable URL</b> will return a URL based on the sites current location (helps when you move a WP site - recommended).<p><b>Static URL</b> will return the default URL.</p><p><b>Attachment object</b> will return an object and all its information for the file.</p>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?=__('Select what information you would like returned when using the get_cf() command to retrieve this file on the frontend','kontrolwp')?>.</div>
    </div>
 
    <div class="item">
        <div class="label"><?=__('File Types Allowed','kontrolwp')?> <?=__('Label')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][file_types_allowed_label]" value="<?=isset($data['file_types_allowed_label']) ? $data['file_types_allowed_label']:__('Files','kontrolwp')." (*.doc, *.docx, *.pdf, *.txt)"?>" class="required sixty" />
        </div>
        <div class="desc"><?=__('When the user browses for an file, this will be label shown for the types of files they can browse','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?=__('File Types Allowed','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][file_types_allowed]" value="<?=isset($data['file_types_allowed']) ? $data['file_types_allowed']:"*.doc; *.docx; *.pdf; *.txt"?>" class="required sixty" />
        </div>
        <div class="desc"><?=__('When the user browses for an file, they will be limited to these file types only. Keep file types seperated by a','kontrolwp')?> ;</div>
    </div>
    <div class="item">
        <div class="label"><?=__('Max File Size Allowed','kontrolwp')?><span class="req-ast">*</span> (<?=__('kilobytes','kontrolwp')?>)</div> 
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][file_size_bytes]" value="<?=isset($data['file_size_bytes']) ? $data['file_size_bytes']:Kontrol_Tools::return_post_max('bytes')?>" class="required validate-integer sixty" /> 
        </div>
        <div class="desc"><?=__('Limit the maximum file size allowed in kilobytes','kontrolwp')?>. <b><?=Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'KB')?></b> / <b><?=Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'MB', 2)?></b> <?=__('is the max supported by your server','kontrolwp')?>.</div>
    </div>
    
</div>