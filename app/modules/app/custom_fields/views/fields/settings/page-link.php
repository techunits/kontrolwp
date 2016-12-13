<?php // Get the post types and taxonomies
	$post_types = array();
	$taxonomies = array();

	foreach($rules['Wordpress'] as $wp_rule) {
		if($wp_rule['key'] == 'post_type') {
			$post_types = $wp_rule['data'];
		}
		if($wp_rule['key'] == 'taxonomies') {
			$taxonomies = $wp_rule['data'];
		}
	}

?>


<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Post Type Filter','kontrolwp')?></div>
        <div>
        	<select name="field[<?php echo $fkey?>][settings][pl_pt_filter][]" class="sixty" multiple="multiple" style="height: 120px">
              	<?php foreach($post_types as $pt_val => $pt_key) { 
						
						$selected = FALSE;
					if(isset($data['pl_pt_filter']) && is_array($data['pl_pt_filter']) && in_array($pt_val, $data['pl_pt_filter'])) { 
						$selected = TRUE; 
					}
				?>
                	<option value="<?php echo $pt_val?>" <?php echo $selected ? 'selected="selected"':''?>><?php echo $pt_key?></option>
                <?php }?>
			</select>
        </div>
        <div class="desc"><?php echo __('Filter the page links by selected post types. If none are selected it will show for all','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Taxonomy Filter','kontrolwp')?></div>
        <div>
        	<select name="field[<?php echo $fkey?>][settings][pl_tax_filter][]" class="sixty" multiple="multiple" style="height: 120px">
              	<?php foreach($taxonomies as $tax_label => $tax_val) { 
					
				     if(isset($tax_val['values']) && is_array($tax_val['values'])) { ?>
                      	<optgroup label="<?php echo $tax_label?>">
                        	<?php foreach($tax_val['values'] as $subvalue => $sublabel) { 
								$selected = FALSE;
								$value = $tax_val['id'].'_'.$subvalue;
								if(isset($data['pl_tax_filter']) && is_array($data['pl_tax_filter']) && in_array($value, $data['pl_tax_filter'])) { 
									$selected = TRUE; 
								}
							?>
                            	 <option value="<?php echo esc_attr($value)?>" <?php echo $selected ? 'selected="selected"':''?>>&nbsp;&nbsp;<?php echo $sublabel?></option>
                            <?php } ?>
                        </optgroup>
                      <?php } 
					} ?>
			</select>
        </div>
        <div class="desc"><?php echo __('Filter the page links by selected taxonomies and terms. If none are selected it will show for all. Note that the post type filter is applied before the taxonomy filter','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Include Search Box','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
             <select name="field[<?php echo $fkey?>][settings][select_search_box]" class="thirty">
                  <option value="false" <?php echo isset($data['select_search_box']) && $data['select_search_box'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                  <option value="true" <?php echo isset($data['select_search_box']) && $data['select_search_box'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('Enabling this will allow your users to search this select field. This is handy on multi selects that have a lot of options','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Allow Null Value?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][select_null]" class="thirty">
              <option value="false" <?php echo isset($data['select_null']) && $data['select_null'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
              <option value="true" <?php echo isset($data['select_null']) && $data['select_null'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('You can allow the user to select a null value as the first option if you enable this','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?php echo __('Maximum Selected Values Allowed','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][select_max_values]" value="<?php echo isset($data['select_max_values']) ? $data['select_max_values']:'1'?>" class="thirty validate-integer required" />
        </div>
        <div class="desc"><?php echo __('If set to 1, a standard select list will appear. If set > 1 a multiple select box will appear and the user will be limited to the number of values they can select according to the number entered here','kontrolwp')?>.</div>
    </div>
    
     <div class="item">
        <div class="label"><?php echo __('Return Type','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][return_type]" class="thirty">
              <option value="post_url" <?php echo isset($data['return_type']) && $data['return_type'] == 'post_url' ? 'selected="selected"':''?>><?php echo __('URL','kontrolwp')?></option>
              <option value="post_object" <?php echo isset($data['return_type']) && $data['return_type'] == 'post_object' ? 'selected="selected"':''?>><?php echo __('Post Object','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('You can select to just return the URL of the pages/posts that the user selects or the post object which includes more information','kontrolwp')?>.</div>
    </div>
    
</div>