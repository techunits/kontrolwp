<div class="field-<?php echo $type?> field-settings">
    <div class="item">
        <div class="label"><?php echo __('Return Type','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][return_type]" class="sixty">
              <option value="url_absolute" <?php echo isset($data['return_type']) && $data['return_type'] == 'url_absolute' ? 'selected="selected"':''?>><?php echo __('Adaptable URL','kontrolwp')?></option>
              <option value="url" <?php echo isset($data['return_type']) && $data['return_type'] == 'url' ? 'selected="selected"':''?>><?php echo __('Static URL','kontrolwp')?></option>
              <option value="post_object" <?php echo isset($data['return_type']) && $data['return_type'] == 'post_object' ? 'selected="selected"':''?>><?php echo __('Attachment Object','kontrolwp')?></option>
            </select>  
            <div class="inline kontrol-tip" title="<?php echo __('Return Type','kontrolwp')?>" data-width="450" data-text="<?php echo htmlentities(__('<b>Adaptable URL</b> will return a URL based on the sites current location (helps when you move a WP site - recommended).<p><b>Static URL</b> will return the default URL.</p><p><b>Attachment object</b> will return an object and all its information for the file.</p>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?php echo __('Select what information you would like returned when using the get_cf() command to retrieve this file on the frontend','kontrolwp')?>.</div>
    </div>
 
    <div class="item">
        <div class="label"><?php echo __('File Types Allowed','kontrolwp')?> <?php echo __('Label')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][file_types_allowed_label]" value="<?php echo isset($data['file_types_allowed_label']) ? $data['file_types_allowed_label']:__('Files','kontrolwp')." (*.doc, *.docx, *.pdf, *.txt)"?>" class="required sixty" />
        </div>
        <div class="desc"><?php echo __('When the user browses for an file, this will be label shown for the types of files they can browse','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('File Types Allowed','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][file_types_allowed]" value="<?php echo isset($data['file_types_allowed']) ? $data['file_types_allowed']:"*.doc; *.docx; *.pdf; *.txt"?>" class="required sixty" />
        </div>
        <div class="desc"><?php echo __('When the user browses for an file, they will be limited to these file types only. Keep file types seperated by a','kontrolwp')?> ;</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Max File Size Allowed','kontrolwp')?><span class="req-ast">*</span> (<?php echo __('kilobytes','kontrolwp')?>)</div> 
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][file_size_bytes]" value="<?php echo isset($data['file_size_bytes']) ? $data['file_size_bytes']:Kontrol_Tools::return_post_max('bytes')?>" class="required validate-integer sixty" /> 
        </div>
        <div class="desc"><?php echo __('Limit the maximum file size allowed in kilobytes','kontrolwp')?>. <b><?php echo Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'KB')?></b> / <b><?php echo Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'MB', 2)?></b> <?php echo __('is the max supported by your server','kontrolwp')?>.</div>
    </div>
    
</div>