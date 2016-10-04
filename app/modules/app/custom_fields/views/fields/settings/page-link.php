<? // Get the post types and taxonomies
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


<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('Post Type Filter','kontrolwp')?></div>
        <div>
        	<select name="field[<?=$fkey?>][settings][pl_pt_filter][]" class="sixty" multiple="multiple" style="height: 120px">
              	<? foreach($post_types as $pt_val => $pt_key) { 
						
						$selected = FALSE;
					if(isset($data['pl_pt_filter']) && is_array($data['pl_pt_filter']) && in_array($pt_val, $data['pl_pt_filter'])) { 
						$selected = TRUE; 
					}
				?>
                	<option value="<?=$pt_val?>" <?=$selected ? 'selected="selected"':''?>><?=$pt_key?></option>
                <? }?>
			</select>
        </div>
        <div class="desc"><?=__('Filter the page links by selected post types. If none are selected it will show for all','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Taxonomy Filter','kontrolwp')?></div>
        <div>
        	<select name="field[<?=$fkey?>][settings][pl_tax_filter][]" class="sixty" multiple="multiple" style="height: 120px">
              	<? foreach($taxonomies as $tax_label => $tax_val) { 
					
				     if(isset($tax_val['values']) && is_array($tax_val['values'])) { ?>
                      	<optgroup label="<?=$tax_label?>">
                        	<? foreach($tax_val['values'] as $subvalue => $sublabel) { 
								$selected = FALSE;
								$value = $tax_val['id'].'_'.$subvalue;
								if(isset($data['pl_tax_filter']) && is_array($data['pl_tax_filter']) && in_array($value, $data['pl_tax_filter'])) { 
									$selected = TRUE; 
								}
							?>
                            	 <option value="<?=esc_attr($value)?>" <?=$selected ? 'selected="selected"':''?>>&nbsp;&nbsp;<?=$sublabel?></option>
                            <? } ?>
                        </optgroup>
                      <? } 
					} ?>
			</select>
        </div>
        <div class="desc"><?=__('Filter the page links by selected taxonomies and terms. If none are selected it will show for all. Note that the post type filter is applied before the taxonomy filter','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Include Search Box','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
             <select name="field[<?=$fkey?>][settings][select_search_box]" class="thirty">
                  <option value="false" <?=isset($data['select_search_box']) && $data['select_search_box'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                  <option value="true" <?=isset($data['select_search_box']) && $data['select_search_box'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('Enabling this will allow your users to search this select field. This is handy on multi selects that have a lot of options','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Allow Null Value?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][select_null]" class="thirty">
              <option value="false" <?=isset($data['select_null']) && $data['select_null'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
              <option value="true" <?=isset($data['select_null']) && $data['select_null'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('You can allow the user to select a null value as the first option if you enable this','kontrolwp')?>.</div>
    </div>
    
    <div class="item">
        <div class="label"><?=__('Maximum Selected Values Allowed','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][select_max_values]" value="<?=isset($data['select_max_values']) ? $data['select_max_values']:'1'?>" class="thirty validate-integer required" />
        </div>
        <div class="desc"><?=__('If set to 1, a standard select list will appear. If set > 1 a multiple select box will appear and the user will be limited to the number of values they can select according to the number entered here','kontrolwp')?>.</div>
    </div>
    
     <div class="item">
        <div class="label"><?=__('Return Type','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][return_type]" class="thirty">
              <option value="post_url" <?=isset($data['return_type']) && $data['return_type'] == 'post_url' ? 'selected="selected"':''?>><?=__('URL','kontrolwp')?></option>
              <option value="post_object" <?=isset($data['return_type']) && $data['return_type'] == 'post_object' ? 'selected="selected"':''?>><?=__('Post Object','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('You can select to just return the URL of the pages/posts that the user selects or the post object which includes more information','kontrolwp')?>.</div>
    </div>
    
</div>