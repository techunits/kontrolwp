 <?

 $index = 0;
 $multi_select = FALSE; 
 $page_list = array();
 $show_page_list = array();
 // Get the values
 $select_vals = isset($field_value) && is_array($field_value) ? $field_value : array($field_value);
 $select_row_vals = array();
 // Mutliple select box
 if(isset($field->settings['select_max_values']) && is_numeric($field->settings['select_max_values']) && $field->settings['select_max_values'] > 1) {
	 $multi_select = TRUE;
 }
 // PT Filter
 $pt_filter = isset($field->settings['pl_pt_filter']) && !empty($field->settings['pl_pt_filter']) ? $field->settings['pl_pt_filter'] : array();
  // Tax Filter
 $tax_filter = isset($field->settings['pl_tax_filter']) && !empty($field->settings['pl_tax_filter']) ? $field->settings['pl_tax_filter'] : array();
 
 // Get all post types if need be
 if(empty($pt_filter)) {
	$pt_filter = get_post_types(array('public'=>TRUE)); 
 }
 
 // Filter by post type if needed
 foreach($pt_filter as $pt) {
	// See what type of post type this is - page or post
	if(is_post_type_hierarchical($pt)) {
		// Heirarchy
		$page_list[$pt] = Kontrol_Tools::page_list_array_indented($pt);	
	}else{ 
		// Posts
		$page_list[$pt] = get_posts(array('post_type' => $pt, 'numberposts'=> -1,  'post_status' => 'publish'));
	}
 }
 ?>

 <? if($field->settings['select_search_box'] == TRUE) { ?>
 		<div class="select-search-box">
             <input type="text" value="" />
             <div class="select-search-box-label"><?=__('Filter')?>...</div>
      	</div>
 <? } ?>
 
 <select <?=!$multi_select ? 'name="_kontrol['.$field->field_key.']"':''?> class="<?=$field_validation?>" <?=$multi_select ? 'multiple="multiple" data-smart-box="true" data-max-val="'.$field->settings['select_max_values'].'"':''?>>
	<?  if($field->settings['select_null'] == TRUE && $index == 0) { ?>
    			<option value=""><?=__('Select')?></option>
    <? 	} ?>
 	<?  foreach($page_list as $pt => $pt_list) { 
			if(count($pt_list) > 0) {
				// Get the post type
				$pt_ob = get_post_type_object($pt);
				$pt_label = $pt_ob->label;
		?>
				<optgroup label="<?=$pt_label?>">
		<?
				foreach($pt_list as $page_id => $page_val) { 
					$selected = FALSE;
					$show = TRUE;
					// If the page val is an object, its a post/non-heirachy
					if(!is_object($page_val)) {
						$page_label = $page_val;
						$page_val = get_page($page_id);
					}else{
						$page_label	= $page_val->post_title;
					}
					// Select if it need too
					if(in_array($page_val->ID, $select_vals)) { $selected = TRUE; }
					// Filter by term if needed
					if(!empty($tax_filter)) {
						$show = FALSE;
						foreach($tax_filter as $term_data) {
							echo $term_data.' ';
							// Taxonomy id is the first part, term id is second
							$term_parts = explode('_', $term_data);
							if(has_term($term_parts[1], $term_parts[0], $page_val->ID)) {
								$show = TRUE;	
							};	
						}
					}
					// Show it?
					if($show) {
						if($selected) {
							$select_row_vals[$page_val->ID] = array('label'=>str_replace('&nbsp;','- ',$page_label), 'optgroup'=>$pt_label);
						}
						?>
						<option value="<?=$page_val->ID?>" <?=$selected ? 'selected="selected"':''?>><?=$page_label?></option>
						<?
					}
				$index++;
				}
			?>
            	</optgroup>
            <?
		  }
		} 
	?>
 </select>
 
  
<? if($multi_select) { ?>

	<? // In here so that the values can be reset if nothing is selected ?> 
 	<input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="" />

	<div class="kontrol-smart-box" data-hide-when-empty="true" data-disable-row-delete="true">
      <div class="section">
          <div class="inside">
               <div class="rows sortable">
               	  <div class="row new-row">
                      <div class="inline tab drag-row"></div>
                      <div class="content inline">[[LABEL]]</div>
                      <div class="delete-row" title="Delete Row"></div>  
                      <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="[[VALUE]]" />
                   </div>
               	  <? foreach($select_vals as $val) { 
				  		if(isset($select_row_vals[$val]['label'])) {
				  ?>
                          <div class="row">
                              <div class="inline tab drag-row"></div>
                              <div class="content inline"><b><?=$select_row_vals[$val]['optgroup']?></b> &nbsp;&nbsp;&nbsp; <?=$select_row_vals[$val]['label']?></div>
                              <div class="delete-row" title="Delete Row"></div>  
                              <input type="hidden" name="_kontrol[<?=$field->field_key?>][]" value="<?=$val?>" />
                           </div>
                   <? } 
				  } ?>
               </div> 
          </div>
      </div> 
   </div>   
<? } ?>
  
 
  
  