<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">
	window.addEvent('domready', function() {
			// Various custom utilities for working with forms
			new kontrol_tax_auto_fill();
			new kontrol_select_add();
			new kontrol_form_hide_show();
			new kontrol_select_custom();
			new kontrol_collapse_show();
			
			// Makes safe characters possible on fields with 'safe-chars' class
			restrict_safe_characters();
			
			 // Validation.
  			new Form.Validator.Inline('post-type-add');
			
			 <? if($action == 'edit') { ?>
			 	// Show the 'update-key-posts' suggestion field if they change the post key ID
				var key = $('kontrol').getElement('#key');
				var key_update_field = $('kontrol').getElement('#update-key-field');
				var key_update_fx = new Fx.Reveal(key_update_field, {duration: 500}).dissolve();
				key.addEvent('blur', function(e) {
					if(this.get('value') != $('kontrol').getElement('#current-key').get('value')) {
						key_update_fx.reveal();
					}else{
						key_update_fx.dissolve();
					}
				});
				
			 
			 <? } ?>
			 
			
	});
</script>


<form id="post-type-add" action="<?=$controller_url?>/save/<?=isset($tax) ? $tax->id:''?>&noheader=true" method="POST">

<!-- Main Col -->
<div class="main-col inline">
	<div class="half inline">
        <div class="section">
        	<div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Settings')?> <span class="tip"><?=__('start here to automatically populate the form','kontrolwp')?></span>
                    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Taxonomy ID', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="key" name="key" value="<?=isset($tax) ? $tax->tax_key:''?>" maxlength="20" data-error-msg="<?=__('This taxonomy ID already exists, please enter another','kontrolwp')?>." class="required ninety safe-chars" /></div>
                            <input type="hidden" id="taxonomies" value='<?=json_encode(str_replace(isset($tax) ? $tax->tax_key:'','',get_taxonomies()))?>' />
                            <div class="desc"><?=__('Max. 20 characters, cannot contain capital letters or spaces', 'kontrolwp')?>.</div>
                        </div>
                        <? if($action == 'edit') { ?>
                        <div id="update-key-field" class="item" style="display: none">
                            <div class="label"><input type="checkbox" id="current-key" name="current-key" value="<?=isset($tax) ? $tax->tax_key:''?>" checked="checked" /> <?=__('Update attached posts and terms to match new taxonomy ID?','kontrolwp')?></div>
                            <div class="desc"><?=__('If this taxonomy already terms and posts attached to it and you change the taxonomy ID, those terms and related post information will be lost. Check the box above to make sure that terms and posts attached to the taxonomy get updated to match the new ID','kontrolwp')?>.</div>
                        </div>
                        <? } ?>
                        <div class="item">
                            <div class="label"><?=__('Name (plural)', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="tax-name" name="args[labels][name]" value="<?=isset($tax) ? $tax->args['labels']['name']:''?>" class="required ninety" /></div>
                            <div class="desc"><?=__('General name for the taxonomy, usually plural - eg. Tags', 'kontrolwp')?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="section collapsible">
           <div class="inside">
            <div class="title icon-menu-title">
               <?=__('Post Types &amp; Features', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                <div class="div"></div>
             </div>
             
             <div class="section-content collapsible-section">
                <div class="form-style">
                    <div class="item">
                    	<div class="kontrol-select-add">
                            <div class="label"><?=__('Add Taxonomy to Selected Post Types', 'kontrolwp')?></div>
                            <div class="field">
                                <select nameToAdd="args[post_types][]" class="sixty">
                                    <option value=""><b><?=__('Native', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <? foreach($pt_native as $pt) { ?>
                                    	  <option value="<?=$pt->cpt_key?>"><?=$pt->name?></option>                             
                                    <? } ?>
                                    <option value="">-------------------</option>
                                    <option value=""><b><?=__('Custom', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <? if(!empty($pt_custom)) { ?>
                                    	 <? foreach($pt_custom as $pt) { ?>
                                    	<option value="<?=$pt->cpt_key?>"><?=$pt->name?></option>     
                                        <? } ?>           
                                    <? }else{ ?>
                                    <option value=""><?=__('No custom post types found', 'kontrolwp')?></option>
                                    <? } ?>
                                </select>
                            </div>
                             <div class="kontrol-select-results">
                             	  <? if(isset($attached_post_types)) {
												foreach($attached_post_types as $pt) { ?>
													<div class="feature"><?=$pt->cpt_name?> <input type="hidden" name="args[post_types][]" value="<?=$pt->cpt_key?>" /></div>
										<? }
									    
								  } ?>
			
                             </div>
                        </div>
                    </div>
        
                </div>
            </div>
          </div>  
       </div>
       
       
       <div class="section collapsible">
       		 <div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Advanced Settings', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                    <div class="div"></div>
                 </div>
                
                <div class="section-content collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Hierarchical', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[hierarchical]" class="sixty">
                                    <option value="true" <?=isset($tax) && $tax->args['hierarchical'] == true ? 'selected="selected"':''?>><?=__('True (similar to a page)', 'kontrolwp')?></option>
                                    <option value="false" <?=isset($tax) && $tax->args['hierarchical'] == false ? 'selected="selected"':''?>><?=__('False (similar to a post)', 'kontrolwp')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Whether the taxonomy is hierarchical. Allows Parent to be specified', 'kontrolwp')?>.</div>
                        </div>
               
                         <div class="item">
                            <div class="label"><?=__('Rewrite', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite]" hideShowType="show" hideShowVal="" hideShowClasses="rewrite-field" class="hide-show sixty custom-select">
                                    <option value="true" <?=isset($tax) && $tax->args['rewrite'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($tax) && $tax->args['rewrite'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="" <?=isset($tax) && is_array($tax->args['rewrite']) ? 'selected="selected"':''?>><?=__('Custom')?><?=isset($tax) && is_string($tax->args['rewrite']) ? ' [ '.$tax->args['rewrite'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Set to false to prevent automatic URL rewriting a.k.a. "pretty permalinks"', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - Slug', 'kontrolwp')?></div>
                            <div class="field"><input type="text" name="args[rewrite][slug]" maxlength="20" value="<?=isset($tax) ? $tax->args['rewrite']['slug']:''?>" class="ninety" /></div>
                            <div class="desc"><?=__("Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy's name", 'kontrolwp')?>.</div>
                        </div>
                         <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - With Front', 'kontrolwp')?></div>
                            <div class="field"> <select name="args[rewrite][with_front]" class="sixty">
                                                    <option value="true" <?=isset($tax) && $tax->args['rewrite']['with_front'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                                    <option value="false" <?=isset($tax) && $tax->args['rewrite']['with_front'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                   			 </select>
                            </div>
                            <div class="desc"><?=__('Allowing permalinks to be prepended with front base - defaults to true', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - Hierarchical', 'kontrolwp')?></div>
                            <div class="field"> <select name="args[rewrite][hierarchical]" class="sixty">
                                                    <option value="true" <?=isset($tax) && $tax->args['rewrite']['hierarchical'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                                    <option value="false" <?=isset($tax) && $tax->args['rewrite']['hierarchical'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                   			 </select>
                            </div>
                            <div class="desc"><?=__('Allow hierarchical urls', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Query Variable', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[query_var]" class="custom-select sixty">
                                    <option value="true" <?=isset($tax->args['query_var']) && $tax->args['query_var'] == true ? 'selected="selected"':''?>><?=__('Use Taxonomy Name', 'kontrolwp')?></option>
                                    <option value="false" <?=isset($tax->args['query_var']) && $tax->args['query_var'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="<?=isset($tax->args['query_var']) && is_string($tax->args['query_var']) ? $tax->args['query_var']:''?>" <?=isset($tax) && is_string($tax->args['query_var']) ? 'selected="selected"':''?> class="custom-val"  confirmText="<?=__('Please enter custom query variable', 'kontrolwp')?>:"><?=__('Custom')?><?=isset($tax) && is_string($tax->args['query_var']) ? ' [ '.$tax->args['query_var'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('False prevents queries or provide a custom string value to use for this post type', 'kontrolwp')?>.</div>
                        </div>
                       
                        
                    </div>
                </div>
            </div>
       </div>
            
        <div class="section collapsible">
        	 <div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Visibility', 'kontrolwp')?> <div class="button-collapse toggle-collapse expand"></div>
                    <div class="div"></div>
                 </div>
                
                <div class="section-content  collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Public', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[public]" class="sixty">
                                    <option value="true" <?=isset($tax->args['public']) && $tax->args['public'] === true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($tax->args['public']) && $tax->args['public'] === false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Should this taxonomy be exposed in the admin UI', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Show in Nav Menus', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_in_nav_menus]" class="sixty" >
                                	<option value="default" <?=isset($tax->args['show_in_nav_menus']) && $tax->args['show_in_nav_menus'] == 'default' ? 'selected="selected"':''?>><?=__('Default')?></option>
                                    <option value="true" <?=isset($tax) && $tax->args['show_in_nav_menus'] === true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($tax) && $tax->args['show_in_nav_menus'] === false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div> 
                            <div class="desc"><?=__('True makes this taxonomy available for selection in navigation menus. If set to default, will use the value of <b>public</b> argument', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Show UI', 'kontrolwp')?></div>
                            <div class="field">
                                <select id="show_ui_field" name="args[show_ui]" class="sixty">
                                	<option value="default" <?=isset($tax->args['show_ui']) && $tax->args['show_ui'] == 'default' ? 'selected="selected"':''?>><?=__('Default')?></option>
                                    <option value="true" <?=isset($tax->args['show_ui']) && $tax->args['show_ui'] === true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($tax->args['show_ui']) && $tax->args['show_ui'] === false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                             </div>
                            <div class="desc"><?=__('Whether to generate a default UI for managing this taxonomy. If set to default, will use the value of <b>public</b> argument', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?=__('Show Tag Cloud', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_tagcloud]" class="sixty" >
                               		<option value="default" <?=isset($tax->args['show_tagcloud']) && $tax->args['show_tagcloud'] == 'default' ? 'selected="selected"':''?>><?=__('Default')?></option>
                                    <option value="true" <?=isset($tax->args['show_tagcloud']) && $tax->args['show_tagcloud'] === true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($tax->args['show_tagcloud']) && $tax->args['show_tagcloud'] === false ? 'selected="selected"':''?>><?=__('No')?></option>                                
                                </select>
                            </div> 
                            <div class="desc"><?=__('If set to default, will use the value of show_ui argument', 'kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
                     
            
            <div class="section collapsible">
              <div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Capabilities', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                    <div class="div"></div>
                 </div>
                
                <div class="section-content collapsible-section">
                    <div class="form-style">
                        
                        <div class="item">
                            <div class="label"><?=__('Advanced Capabilities', 'kontrolwp')?></div>
                            <div class="field">
                                <select hideShowType="show" hideShowVal="true" hideShowClasses="adv-cap" class="hide-show sixty">
                                    <option value="false" <?=!isset($tax->args['capabilities']['manage_terms']) ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="true" <?=isset($tax->args['capabilities']['manage_terms']) ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Use the default capabilities, or take full control over specific capability names', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item adv-cap">
                            <div class="label"><?=__('Manage Terms Capability', 'kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][manage_terms]" value="<?=isset($tax->args['capabilities']['manage_terms']) ? $tax->args['capabilities']['manage_terms']:''?>" class="ninety">
                            </div>
                          
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Edit Terms Capability', 'kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_terms]" value="<?=isset($tax->args['capabilities']['edit_terms']) ? $tax->args['capabilities']['edit_terms']:''?>" class="ninety">
                            </div>
                         
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Delete Terms Capability', 'kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][assign_terms]" value="<?=isset($tax->args['capabilities']['assign_terms']) ? $tax->args['capabilities']['assign_terms']:''?>" class="ninety">
                            </div>
                         
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Assign Terms Capability', 'kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][publish_posts]"  value="<?=isset($tax->args['capabilities']['publish_posts']) ? $tax->args['capabilities']['publish_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability to grant publishing of these types of posts', 'kontrolwp')?>.</div>
                        </div>
                      
                        
                    </div>
                </div>
            </div>
           </div>
            
    </div><div class="half inline">
        <div class="section">
           <div class="inside">
            <div class="title icon-menu-title">
                <?=__('Labels', 'kontrolwp')?> <span class="tip"><?=__('various labels for the taxonomy (all required)', 'kontrolwp')?></span>
                <div class="div"></div>
             </div>
            
            <div class="section-content">
                <div class="form-style">
                    <div class="item">
                        <div class="label"><?=__('Name (singular)','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][singular_name]" value="<?=isset($tax) ? $tax->args['labels']['singular_name']:''?>" class="auto-fill singular ninety required" /></div>
                        <div class="desc"><?=__('Singular version of the name','kontrolwp')?> - eg. <?=__('Tag')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Menu Name','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][menu_name]" value="<?=isset($tax) ? $tax->args['labels']['menu_name']:''?>" class="auto-fill plural ninety required" /></div>
                        <div class="desc"><?=__('The menu name text','kontrolwp')?> - eg. <?=__('Tags')?></div>
                    </div>
                   <div class="item">
                        <div class="label"><?=__('Add New Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_new_item]" value="<?=isset($tax) ? $tax->args['labels']['add_new_item']:''?>"  appendLabelText="<?=__('Add New','kontrolwp')?>" class="auto-fill singular append  ninety required" /></div>
                        <div class="desc"><?=__('The add new item text - eg. Add New','kontrolwp')?> <?=__('Tag')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Edit Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][edit_item]" value="<?=isset($tax) ? $tax->args['labels']['edit_item']:''?>" appendLabelText="<?=__('Edit','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The edit item text - eg. Edit','kontrolwp')?> <?=__('Tag')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Update Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][update_item]" value="<?=isset($tax) ? $tax->args['labels']['update_item']:''?>" appendLabelText="<?=__('Update','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The update item text - eg. Update','kontrolwp')?> <?=__('Tag')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('New Item Name','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][new_item_name]" value="<?=isset($tax) ? $tax->args['labels']['new_item_name']:''?>" appendLabelText="<?=__('New','kontrolwp')?> []u <?=__('Name','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The new item text - eg. New','kontrolwp')?> <?=__('Tag')?> <?=__('Name','kontrolwp')?></div>
                    </div>
                   <div class="item">
                        <div class="label"><?=__('All Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][all_items]" value="<?=isset($tax) ? $tax->args['labels']['all_items']:''?>" appendLabelText="<?=__('All','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('Listing all items - eg. All','kontrolwp')?> <?=__('Tags')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Search Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][search_items]" value="<?=isset($tax) ? $tax->args['labels']['search_items']:''?>" appendLabelText="<?=__('Search','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('Searching for an item text - eg. Search','kontrolwp')?> <?=__('Tags')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Popular Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][popular_items]" value="<?=isset($tax) ? $tax->args['labels']['popular_items']:''?>" appendLabelText="<?=__('Popular','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('The popular items text - eg. Popular','kontrolwp')?> <?=__('Tags')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Parent Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][parent_item]" value="<?=isset($tax) ? $tax->args['labels']['parent_item']:''?>" appendLabelText="<?=__('Parent','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('How the parent item is referred to - eg. Parent','kontrolwp')?> <?=__('Tag')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Separate Items With Commas','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][separate_items_with_commas]" value="<?=isset($tax) ? $tax->args['labels']['separate_items_with_commas']:''?>" appendLabelText="<?=__('Separate','kontrolwp')?> [] <?=__('with commas','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__("The separate item with commas text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies - eg. Separate tags with commas",'kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Add or Remove Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_or_remove_items]" value="<?=isset($tax) ? $tax->args['labels']['add_or_remove_items']:''?>" appendLabelText="<?=__('Add or remove','kontrolwp')?> []" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__("The add or remove items text and used in the meta box when JavaScript is disabled. This string isn't used on hierarchical taxonomies - eg Add or remove tags",'kontrolwp')?></div>
                    </div>
  					<div class="item">
                        <div class="label"><?=__('Choose From Most Used','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][choose_from_most_used]" value="<?=isset($tax) ? $tax->args['labels']['choose_from_most_used']:''?>" appendLabelText="<?=__('Choose from the most used','kontrolwp')?> []" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__("The choose from most used text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies - eg Choose from the most used tags",'kontrolwp')?> </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<input type="hidden" name="active" value="<?=isset($tax) ? $tax->active:''?>" />
<input type="hidden" name="sort_order" value="<?=isset($tax) ? $tax->sort_order:''?>" />

 <!-- Side Col -->
<div class="side-col inline">
    <?php $this->renderElement('tax-'.$action.'-side-col', array('controller_url' => $controller_url, 'tax_count' => $tax_count)); ?>
</div>

</form>