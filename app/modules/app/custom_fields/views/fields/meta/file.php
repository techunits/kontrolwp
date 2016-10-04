<?	
	// Get the image
	if(!empty($field_value)) {
		$file_link = wp_get_attachment_link($field_value);
	}
	
	$post_id = NULL;
	
	if(isset($post->ID)) {
		$post_id = $post->ID;
	}
?>

<div class="kontrol-file-upload single-image" 
		data-fileUploadType="file" 
        data-fileReturnInputName="_kontrol[<?=$field->field_key?>]" 
        data-fileReturn="attachment_id" 
        data-fileGetData='<?=http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>$post_id))?>'
        data-fileListMax="1" 
        data-multiple="false" 
        data-maxSize="<?=$field->settings['file_size_bytes']?>" 
        data-fileTypes="{'<?=$field->settings['file_types_allowed_label']?>':'<?=$field->settings['file_types_allowed']?>'}"
        >
    <input type="button" class="upload-el <?=$field_validation?>" value="<?=__('Upload File','kontrolwp')?>" style="<?=isset($file_link) ? 'display:none':''?>"  />
    <ul class="upload-list">
     <? if(isset($file_link)) { ?>
            <li class="file remove" id="file-1">
                   <div class="remove-file"></div>
                   <div class="file-image"><?=$file_link?></div>
                <input type="hidden" id="_kontrol[<?=$field->field_key?>]" name="_kontrol[<?=$field->field_key?>]" value="<?=$field_value?>">
            </li>
     <? } ?>
    </ul>
</div>
