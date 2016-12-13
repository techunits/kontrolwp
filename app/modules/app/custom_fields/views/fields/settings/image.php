<div class="field-<?php echo $type?> field-settings">
    <div class="item">
        <div class="label"><?php echo __('Return Type','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][return_type]" class="sixty">
              <option value="url_absolute" <?php echo isset($data['return_type']) && $data['return_type'] == 'url_absolute' ? 'selected="selected"':''?>><?php echo __('Adaptable URL','kontrolwp')?></option>
              <option value="url" <?php echo isset($data['return_type']) && $data['return_type'] == 'url' ? 'selected="selected"':''?>><?php echo __('Static URL','kontrolwp')?></option>
              <option value="post_object" <?php echo isset($data['return_type']) && $data['return_type'] == 'post_object' ? 'selected="selected"':''?>><?php echo __('Attachment Object','kontrolwp')?></option>
            </select>  
            <div class="inline kontrol-tip" title="Return Type" data-width="450" data-text="<?php echo htmlentities(__('<b>Adaptable URL</b> will return a URL based on the sites current location (helps when you move a WP site - recommended).<p><b>Static URL</b> will return the default URL.</p><p><b>Attachment object</b> will return an object and all its information for the file.</p>','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?php echo __('Select what information you would like returned when using the get_cf() command to retrieve this file on the frontend','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Preview Size','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][image_preview_size]" class="sixty">
              <option value="thumbnail" <?php echo isset($data['image_preview_size']) && $data['image_preview_size'] == 'thumbnail' ? 'selected="selected"':''?>><?php echo __('Thumbnail')?></option>
              <option value="medium" <?php echo isset($data['image_preview_size']) && $data['image_preview_size'] == 'medium' ? 'selected="selected"':''?>><?php echo __('Medium')?></option>
              <option value="large" <?php echo isset($data['image_preview_size']) && $data['image_preview_size'] == 'large' ? 'selected="selected"':''?>><?php echo __('Large')?></option>
              <option value="full" <?php echo isset($data['image_preview_size']) && $data['image_preview_size'] == 'full' ? 'selected="selected"':''?>><?php echo __('Full')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('When an image is uploaded, this is the size of the preview that will be displayed','kontrolwp')?>.</div>
    </div>
   
        
    <!-- Image Effects -->
    <?php echo $this->renderElement('cf-image-effects', array('fkey'=>$fkey, 'data'=>$data, 'type'=>$type, 'copy'=>NULL));?>
    
    <div class="item">
        <div class="label"><?php echo __('Image Types Allowed','kontrolwp')?> <?php echo __('Label')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" id="file_types_allowed_label" name="field[<?php echo $fkey?>][settings][image_file_types_allowed_label]" value="<?php echo isset($data['image_file_types_allowed_label']) ? $data['image_file_types_allowed_label']:__('Images')." (*.jpg, *.jpeg, *.gif, *.png)"?>" class="required sixty" />
        </div>
        <div class="desc"><?php echo __('When the user browses for an image, this will be the label shown for the types of images they can browse','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Image Types Allowed','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <input type="text" id="file_types_allowed" name="field[<?php echo $fkey?>][settings][image_file_types_allowed]" value="<?php echo isset($data['image_file_types_allowed']) ? $data['image_file_types_allowed']:"*.jpg; *.jpeg; *.gif; *.png"?>" class="required sixty" />
        </div>
        <div class="desc"><?php echo __('When the user browses for an image, they will be limited to these file types only. Keep image types seperated by a','kontrolwp')?> ;</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Max File Size Allowed','kontrolwp')?><span class="req-ast">*</span> (<?php echo __('kilobytes','kontrolwp')?>)</div> 
        <div class="field">
            <input type="text" id="file_size_bytes" name="field[<?php echo $fkey?>][settings][image_file_size_bytes]" value="<?php echo isset($data['image_file_size_bytes']) ? $data['image_file_size_bytes']:Kontrol_Tools::return_post_max('bytes')?>" class="required validate-integer sixty" /> 
        </div>
        <div class="desc"><?php echo __('Limit the maximum file size allowed in kilobytes','kontrolwp')?>. <b><?php echo Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'KB')?></b> / <b><?php echo Kontrol_Tools::byte_format(Kontrol_Tools::return_post_max('bytes'), 'MB', 2)?></b> <?php echo __('is the max supported by your server','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Generate Image Copies?','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][image_copies]" data-hide-show-parent=".field-<?php echo $type?>" class="sixty hide-show">
              	<option value="false" data-hide-classes="image-copies" <?php echo isset($data['image_copies']) && $data['image_copies'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                <option value="true" data-show-classes="image-copies" <?php echo isset($data['image_copies']) && $data['image_copies'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select> 
            <div class="inline kontrol-tip" title="<?php echo __('Generate Image Copies?','kontrolwp')?>" data-text="<?php echo htmlentities(sprintf(__('A common use is to generate a thumbnail copy of the image.<p>If you generate copies, these copies will be returned as an array when using the <strong>get_cf()</strong> command when retrieving the main image. The image array returned will contain two index keys, one called %s and one called %s that contains an array of copies','kontrolwp'),'"<b>original</b>"','"<b>copies</b>"').'.</p>
            																												  <p><b>'.__('Example','kontrolwp').'</b> - '.__('Using <b>get_cf(\'your-main-image-key\')</b> on an image field with copies, will return an array similar to this','kontrolwp').'.</p>
			<p><pre>Array
(
    [original] =&gt; uploaded-image.jpg
    [copies] =&gt; Array
        (
            [copy-key-1] =&gt; copy-0-uploaded-image.jpg
            [copy-key-2] =&gt; copy-1-uploaded-image.jpg
        )

)</pre></p>', ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?php echo __('You can automatically generate copies of the uploaded image at different sizes with different effects + more','kontrolwp')?>.</div>
    </div>
    
    <div class="image-copies">
    	<?php if(isset($data['image_copy']) && is_array($data['image_copy']) && count($data['image_copy']) > 0) { 
				$index = 1;
				foreach($data['image_copy'] as $copy) {
		?>
        			<?php echo $this->renderElement('cf-image-copy', array('fkey'=>$fkey, 'data'=>$copy, 'type'=>$type, 'index'=> $index));?>
        <?php      	$index++;
				}
		}else{ ?>
        	<?php echo $this->renderElement('cf-image-copy', array('fkey'=>$fkey, 'data'=>NULL, 'type'=>$type, 'index'=> 1));?>
        <?php } ?>
    </div>
    
    
</div>