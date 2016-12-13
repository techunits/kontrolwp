<?php
	
	// Get the image
	if(!empty($field_value)) {
		$field_value_attach_id = $field_value;
		// If it has a comma seperated value, only the first is the original image, the others are copies
		if(strpos($field_value, ',') !== false) {
			 // Get the image ids
			 $attach_ids = explode(',', $field_value);
			 $field_value_attach_id = $attach_ids[0];
		}
		// Get the image now
		$image_src = wp_get_attachment_image($field_value_attach_id, $field->settings['image_preview_size']);
	}
	
	$post_id = NULL;
	
	if(isset($post->ID)) {
		$post_id = $post->ID;
	}


?>


<div class="kontrol-file-upload single-image" 
		data-fileUploadType="image" 
        data-fileReturnInputName="_kontrol[<?php echo $field->field_key?>]" 
        data-fileReturn="attachment_id" 
        data-fileGetData='<?php echo http_build_query(array(
							'user_id'=>$current_user->ID, 
							'post_id'=>$post_id, 
							'data'=>$field->settings
						))?>' 
        data-fileListMax="1" 
        data-multiple="false" 
        data-upload-effects="true" 
        data-maxSize="<?php echo $field->settings['image_file_size_bytes']?>" 
        data-fileTypes="{'<?php echo $field->settings['image_file_types_allowed_label']?>':'<?php echo $field->settings['image_file_types_allowed']?>'}"
        > 
    <input type="button" class="upload-el <?php echo $field_validation?>" value="<?php echo __('Upload Image','kontrolwp')?>" style="<?php echo isset($image_src) ? 'display:none':''?>"  />
    <ul class="upload-list">
     <?php if(isset($image_src)) { ?>
            <li class="file remove" id="file-1">
                   <div class="remove-file"></div>
                   <div class="file-image"><?php echo $image_src?></div>
                <input type="hidden" id="_kontrol[<?php echo $field->field_key?>]" name="_kontrol[<?php echo $field->field_key?>]" value="<?php echo $field_value?>">
            </li>
     <?php } ?>
    </ul>
</div>
