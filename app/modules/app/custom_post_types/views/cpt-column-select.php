<?php 

	$taxonomies = get_object_taxonomies($pt_key, 'objects'); 
	

	// Backwards compatibility before 1.0.4
	if(!is_array($col)) {
		$post_link = $col == 'title' ? 1 : 0;
		$col = array('type'=>$col, 'post_link'=>$post_link);
	}

	
?>

<div class="col inline">
    <div class="drag-row inline"></div><div class="inline select">
            <select class="custom-select" name="columns[<?php echo empty($count) ? 'RANDKEY' : $count?>][type]">		
                <option value="default" <?php echo (isset($col['type']) && $col['type'] == 'default') ? 'selected="selected"':'' ?>><?php echo __('Default Columns','kontrolwp')?></option>	
                <option value="">-----------------------</option>																				 
                <option value="<?php echo (isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? $col['type']:'' ?>" <?php echo (isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="kontrol_cf:%s" customLabelFormat="<?php echo __('Kontrol Custom Field','kontrolwp')?> (%s)" confirmText="<?php echo __('Enter the Kontrol custom field key for the field you want shown in this column','kontrolwp')?>.">Kontrol <?php echo __('Custom Field','kontrolwp')?> <?php echo (isset($col['type']) && strpos($col['type'], 'kontrol_cf:') !== FALSE) ? '('.substr($col['type'], 11, strlen($col['type'])).')':'' ?></option>
               
                <?php if(count($taxonomies) > 0) { ?>
                	 <option value="">-----------------------</option>
                     <?php foreach($taxonomies as $tax) { ?>
                     		<option value="taxonomy:<?php echo $tax->name?>" <?php echo (isset($col['type']) && strpos($col['type'], 'taxonomy:') !== FALSE && $col['type'] == 'taxonomy:'.$tax->name) ? 'selected="selected"':'' ?>><?php echo __('Taxonomy','kontrolwp')?> - <?php echo $tax->label?></option>
                     <?php } ?>
                <?php } ?>	
                 <option value="">-----------------------</option>
                <option value="permalink" <?php echo (isset($col['type']) && $col['type'] == 'permalink') ? 'selected="selected"':'' ?>><?php echo __('Post Permalink','kontrolwp')?> (URL)</option>
                <option value="author" <?php echo (isset($col['type']) && $col['type'] == 'author') ? 'selected="selected"':'' ?>><?php echo __('Post Author','kontrolwp')?></option>
                <option value="title" <?php echo (isset($col['type']) && $col['type'] == 'title') ? 'selected="selected"':'' ?>><?php echo __('Post Title','kontrolwp')?></option>
                <option value="date" <?php echo (isset($col['type']) && $col['type'] == 'date') ? 'selected="selected"':'' ?>><?php echo __('Post Date','kontrolwp')?></option>
                <option value="<?php echo (isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? $col['type']:'' ?>" <?php echo (isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="date:%s" customLabelFormat="<?php echo __('Post Date Formatted','kontrolwp')?> (%s)"  confirmDefaultVal="d/m/Y" confirmText="<?php echo __('Enter the PHP date format to display the post date as','kontrolwp')?> eg. d/m/Y = <?php echo date('d/m/Y')?>"><?php echo __('Post Date Formatted','kontrolwp')?> <?php echo (isset($col['type']) && strpos($col['type'], 'date:') !== FALSE) ? '('.substr($col['type'], 5, strlen($col['type'])).')':'' ?></option>
                <option value="<?php echo (isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? $col['type']:'' ?>" <?php echo (isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? 'selected="selected"':'' ?> class="custom-val" customValFormat="modified:%s" customLabelFormat="<?php echo __('Post Modified Formatted','kontrolwp')?> (%s)"  confirmDefaultVal="d/m/Y" confirmText="<?php echo __('Enter the PHP date format to display the post modified date as','kontrolwp')?> eg. d/m/Y = <?php echo date('d/m/Y')?> - <?php echo __('Leave blank for the default','kontrolwp')?>."><?php echo __('Post Modified Formatted','kontrolwp')?> <?php echo (isset($col['type']) && strpos($col['type'], 'modified:') !== FALSE) ? '('.substr($col['type'], 9, strlen($col['type'])).')':'' ?></option>
                <option value="excerpt" <?php echo (isset($col['type']) && $col['type'] == 'excerpt') ? 'selected="selected"':'' ?>><?php echo __('Post Excerpt','kontrolwp')?></option>
                <option value="post_type" <?php echo (isset($col['type']) && $col['type'] == 'post_type') ? 'selected="selected"':'' ?>><?php echo __('Post Type','kontrolwp')?></option>
                <option value="status" <?php echo (isset($col['type']) && $col['type'] == 'status') ? 'selected="selected"':'' ?>><?php echo __('Post Status','kontrolwp')?></option>
                <option value="categories" <?php echo (isset($col['type']) && $col['type'] == 'categories') ? 'selected="selected"':'' ?>><?php echo __('Post Category','kontrolwp')?></option>
                <option value="tags" <?php echo (isset($col['type']) && $col['type'] == 'tags') ? 'selected="selected"':'' ?>><?php echo __('Post Tag','kontrolwp')?></option>
                <option value="name" <?php echo (isset($col['type']) && $col['type'] == 'name') ? 'selected="selected"':'' ?>><?php echo __('Post Name','kontrolwp')?></option>
                <option value="parent" <?php echo (isset($col['type']) && $col['type'] == 'parent') ? 'selected="selected"':'' ?>><?php echo __('Post Parent','kontrolwp')?></option>
                <option value="menu_order" <?php echo (isset($col['type']) && $col['type'] == 'menu_order') ? 'selected="selected"':'' ?>><?php echo __('Post Menu Order','kontrolwp')?></option>
                <option value="ping_status" <?php echo (isset($col['type']) && $col['type'] == 'ping_status') ? 'selected="selected"':'' ?>><?php echo __('Ping Status','kontrolwp')?></option>
                <option value="comment_status" <?php echo (isset($col['type']) && $col['type'] == 'comment_status') ? 'selected="selected"':'' ?>><?php echo __('Comment Status','kontrolwp')?></option>
                <option value="comments" <?php echo (isset($col['type']) && $col['type'] == 'comments') ? 'selected="selected"':'' ?>><?php echo __('Comment Count','kontrolwp')?></option>
            </select>
            <div class="col-post-link">
            	<input type="checkbox" name="columns[<?php echo empty($count) ? 'RANDKEY' : $count?>][post_link]" value="1" <?php echo isset($col['post_link']) && $col['post_link'] == '1' ? 'checked':''?>  /> <?php echo __('Link to edit post','kontrolwp')?>
            </div>
    </div>
    <div class="inline duplicate-parent <?php echo !empty($count) ? 'delete' : ''?>" data-add-unqiue-key="true" data-add-unqiue-key-format="RANDKEY"></div>
</div>