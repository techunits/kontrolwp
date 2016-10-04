<? 

	$taxonomies = get_object_taxonomies($pt_key, 'objects'); 
	

	// Backwards compatibility before 1.0.4
	if(!is_array($col)) {
		$post_link = $col == 'title' ? 1 : 0;
		$col = array('type'=>$col, 'post_link'=>$post_link);
	}

	
?>

<div class="col inline">
    <div class="drag-row inline"></div><div class="inline select">
            <select class="custom-select" name="columns[<?=empty($count) ? 'RANDKEY' : $count?>][type]">		
                <option value="default" <?=(isset($col['type']) && $col['type'] == 'default') ? 'selected="selected"':'' ?>><?=__('Default Columns','kontrolwp')?></option>	
                <option value="">-----------------------</option>																				 
                <option value="<?=(isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? $col['type']:'' ?>" <?=(isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="kontrol_cf:%s" customLabelFormat="<?=__('Kontrol Custom Field','kontrolwp')?> (%s)" confirmText="<?=__('Enter the Kontrol custom field key for the field you want shown in this column','kontrolwp')?>.">Kontrol <?=__('Custom Field','kontrolwp')?> <?=(isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? '('.substr($col['type'], 11, strlen($col['type'])).')':'' ?></option>
               
                <? if(count($taxonomies) > 0) { ?>
                	 <option value="">-----------------------</option>
                     <? foreach($taxonomies as $tax) { ?>
                     		<option value="taxonomy:<?=$tax->name?>" <?=(isset($col['type']) && strpos($col['type'], 'taxonomy:') !== FALSE && $col['type'] == 'taxonomy:'.$tax->name) ? 'selected="selected"':'' ?>><?=__('Taxonomy','kontrolwp')?> - <?=$tax->label?></option>
                     <? } ?>
                <? } ?>	
                 <option value="">-----------------------</option>
                <option value="permalink" <?=(isset($col['type']) && $col['type'] == 'permalink') ? 'selected="selected"':'' ?>><?=__('Post Permalink','kontrolwp')?> (URL)</option>
                <option value="author" <?=(isset($col['type']) && $col['type'] == 'author') ? 'selected="selected"':'' ?>><?=__('Post Author','kontrolwp')?></option>
                <option value="title" <?=(isset($col['type']) && $col['type'] == 'title') ? 'selected="selected"':'' ?>><?=__('Post Title','kontrolwp')?></option>
                <option value="date" <?=(isset($col['type']) && $col['type'] == 'date') ? 'selected="selected"':'' ?>><?=__('Post Date','kontrolwp')?></option>
                <option value="<?=(isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? $col['type']:'' ?>" <?=(isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="date:%s" customLabelFormat="<?=__('Post Date Formatted','kontrolwp')?> (%s)"  confirmDefaultVal="d/m/Y" confirmText="<?=__('Enter the PHP date format to display the post date as','kontrolwp')?> eg. d/m/Y = <?=date('d/m/Y')?>"><?=__('Post Date Formatted','kontrolwp')?> <?=(isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? '('.substr($col['type'], 5, strlen($col['type'])).')':'' ?></option>
                <option value="<?=(isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? $col['type']:'' ?>" <?=(isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="modified:%s" customLabelFormat="<?=__('Post Modified Formatted','kontrolwp')?> (%s)"  confirmDefaultVal="d/m/Y" confirmText="<?=__('Enter the PHP date format to display the post modified date as','kontrolwp')?> eg. d/m/Y = <?=date('d/m/Y')?> - <?=__('Leave blank for the default','kontrolwp')?>."><?=__('Post Modified Formatted','kontrolwp')?> <?=(isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? '('.substr($col['type'], 9, strlen($col['type'])).')':'' ?></option>
                <option value="excerpt" <?=(isset($col['type']) && $col['type'] == 'excerpt') ? 'selected="selected"':'' ?>><?=__('Post Excerpt','kontrolwp')?></option>
                <option value="post_type" <?=(isset($col['type']) && $col['type'] == 'post_type') ? 'selected="selected"':'' ?>><?=__('Post Type','kontrolwp')?></option>
                <option value="status" <?=(isset($col['type']) && $col['type'] == 'status') ? 'selected="selected"':'' ?>><?=__('Post Status','kontrolwp')?></option>
                <option value="categories" <?=(isset($col['type']) && $col['type'] == 'categories') ? 'selected="selected"':'' ?>><?=__('Post Category','kontrolwp')?></option>
                <option value="tags" <?=(isset($col['type']) && $col['type'] == 'tags') ? 'selected="selected"':'' ?>><?=__('Post Tag','kontrolwp')?></option>
                <option value="name" <?=(isset($col['type']) && $col['type'] == 'name') ? 'selected="selected"':'' ?>><?=__('Post Name','kontrolwp')?></option>
                <option value="parent" <?=(isset($col['type']) && $col['type'] == 'parent') ? 'selected="selected"':'' ?>><?=__('Post Parent','kontrolwp')?></option>
                <option value="menu_order" <?=(isset($col['type']) && $col['type'] == 'menu_order') ? 'selected="selected"':'' ?>><?=__('Post Menu Order','kontrolwp')?></option>
                <option value="ping_status" <?=(isset($col['type']) && $col['type'] == 'ping_status') ? 'selected="selected"':'' ?>><?=__('Ping Status','kontrolwp')?></option>
                <option value="comment_status" <?=(isset($col['type']) && $col['type'] == 'comment_status') ? 'selected="selected"':'' ?>><?=__('Comment Status','kontrolwp')?></option>
                <option value="comments" <?=(isset($col['type']) && $col['type'] == 'comments') ? 'selected="selected"':'' ?>><?=__('Comment Count','kontrolwp')?></option>
            </select>
            <div class="col-post-link">
            	<input type="checkbox" name="columns[<?=empty($count) ? 'RANDKEY' : $count?>][post_link]" value="1" <?=isset($col['post_link']) && $col['post_link'] == '1' ? 'checked':''?>  /> <?=__('Link to edit post','kontrolwp')?>
            </div>
    </div>
    <div class="inline duplicate-parent <?=!empty($count) ? 'delete' : ''?>" data-add-unqiue-key="true" data-add-unqiue-key-format="RANDKEY"></div>
</div>