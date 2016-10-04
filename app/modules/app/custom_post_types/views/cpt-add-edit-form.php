<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">
	window.addEvent('domready', function() {
			// Various custom utilities for working with forms
			new kontrol_auto_fill();
			new kontrol_select_add();
			new kontrol_form_hide_show();
			new kontrol_select_custom();
			new kontrol_collapse_show();
			
			// Makes safe characters possible on fields with 'safe-chars' class
			restrict_safe_characters();
			
			new kontrol_file_upload({
					'file_size_max': <?=Kontrol_Tools::return_post_max('bytes')?>,
					'app_path': '<?=URL_PLUGIN?>'
				});		
			
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



<form id="post-type-add" action="<?=$controller_url?>/save/<?=isset($cpt) ? $cpt->id:''?>&noheader=true" method="POST">

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
                            <div class="label"><?=__('Post Type ID', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="key" name="key" value="<?=isset($cpt) ? $cpt->cpt_key:''?>" maxlength="20" data-error-msg="<?=__('This post type ID already exists, please enter another','kontrolwp')?>." class="required ninety safe-chars" /></div>
                            <input type="hidden" id="cpts" value='<?=json_encode(str_replace(isset($cpt) ? $cpt->cpt_key:'','',get_post_types()))?>' />
                            <div class="desc"><?=__('Max. 20 characters, cannot contain capital letters or spaces', 'kontrolwp')?>.</div>
                        </div>
                        <? if($action == 'edit') { ?>
                        <div id="update-key-field" class="item" style="display: none">
                            <div class="label"><input type="checkbox" id="current-key" name="current-key" value="<?=isset($cpt) ? $cpt->cpt_key:''?>" checked="checked" /> <?=__('Update current posts attached to post type?', 'kontrolwp')?></div>
                            <div class="desc"><?=__('If this post type already has posts attached to it and you change the post type ID they will be lost, check the box above to make sure those posts get updated to match the new ID', 'kontrolwp')?>.</div>
                        </div>
                        <? } ?>
                        <div class="item">
                            <div class="label"><?=__('Name (plural)', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="post-name" name="args[labels][name]" value="<?=isset($cpt) ? $cpt->args['labels']['name']:''?>" class="required ninety" /></div>
                            <div class="desc"><?=__('General name for the post type, usually plural - eg. Movies', 'kontrolwp')?></div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Description')?></div>
                            <div class="field"><textarea name="args[description]" class="ninety"><?=isset($cpt) ? $cpt->args['description']:''?></textarea></div>
                            <div class="desc"><?=__('A short descriptive summary of what the post type is', 'kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="section collapsible">
           <div class="inside">
            <div class="title icon-menu-title">
               <?=__('Supported Taxonomies &amp; Features', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                <div class="div"></div>
             </div>
             
             <div class="section-content collapsible-section">
                <div class="form-style">
                    <div class="item">
                    	<div class="kontrol-select-add">
                            <div class="label"><?=__('Add Taxonomies', 'kontrolwp')?></div>
                            <div class="field">
                                <select nameToAdd="args[taxonomies][]" class="sixty">
                                    <option value=""><b><?=__('Native', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <? foreach($tax_native as $tax) { ?>
                                    	  <option value="<?=$tax->tax_key?>"><?=$tax->name?></option>                             
                                    <? } ?>
                                    <option value="">-------------------</option>
                                    <option value=""><b><?=__('Custom', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <? if(!empty($tax_custom)) { ?>
                                    	 <? foreach($tax_custom as $tax) { ?>
                                    	<option value="<?=$tax->tax_key?>"><?=$tax->name?></option>     
                                        <? } ?>           
                                    <? }else{ ?>
                                    <option value=""><?=__('No custom taxonomies found', 'kontrolwp')?></option>
                                    <? } ?>
                                </select>
                            </div>
                             <div class="kontrol-select-results">
                             	  <? if(isset($attached_taxonomies)) {
												foreach($attached_taxonomies as $pt) { ?>
													<div class="feature"><?=$pt->tax_name?> <input type="hidden" name="args[taxonomies][]" value="<?=$pt->tax_key?>" /></div>
										<? }
									    
								  } ?>
			
                             </div>
                        </div>
                    </div>
               
                    <div class="item">
                    	<div class="kontrol-select-add">
                            <div class="label"><?=__('Add Features', 'kontrolwp')?></div>
                            <div class="field">
                            	<input type="hidden" name="args[supports][]" value="" />
                                <select nameToAdd="args[supports][]" class="sixty">
                                    <option value=""><?=__('Choose', 'kontrolwp')?>...</option>
                                    <option value="">-------------------</option>
                                    <option value="title"><?=__('Title')?></option>
                                    <option value="editor"><?=__('Editor')?></option>
                                    <option value="page-attributes"><?=__('Page Attributes')?></option>
                                    <option value="excerpt"><?=__('Excerpt')?></option>
                                    <option value="author"><?=__('Author')?></option>
                                    <option value="thumbnail"><?=__('Thumbnail')?></option>
                                    <option value="trackbacks"><?=__('Trackbacks')?></option>
                                    <option value="custom-fields"><?=__('Custom Fields')?></option>
                                    <option value="comments"><?=__('Comments')?></option>
                                    <option value="revisions"><?=__('Revisions')?></option>
                                    <option value="post-formats"><?=__('Post Formats')?></option>
                                </select>
                            </div>
                             <div class="kontrol-select-results">
                            <? if(isset($cpt)) {
									if(is_array($cpt->args['supports'])) { 
										sort($cpt->args['supports']);
										foreach( $cpt->args['supports'] as $support) { 
											if(!empty($support)) { ?>
                             				<div class="feature"><?=ucwords(str_replace('-', ' ',$support))?> <input type="hidden" name="args[supports][]" value="<?=$support?>" /></div>
                                <? 		}
										}
								} ?>
                            <? }else{ ?>
                                    <div class="feature"><?=__('Title')?> <input type="hidden" name="args[supports][]" value="title" /></div>
                                    <div class="feature"><?=__('Editor')?> (wysiwyg)<input type="hidden" name="args[supports][]" value="editor" /></div>
                            <? } ?>
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
                                    <option value="true" <?=isset($cpt) && $cpt->args['hierarchical'] == true ? 'selected="selected"':''?>><?=__('True (similar to a page)', 'kontrolwp')?></option>
                                    <option value="false" <?=isset($cpt) && $cpt->args['hierarchical'] == false ? 'selected="selected"':''?>><?=__('False (similar to a post)', 'kontrolwp')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Whether the post type is hierarchical. Allows Parent to be specified', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Has Archive', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[has_archive]" class="sixty">
                                    <option value="true" <?=isset($cpt) && $cpt->args['has_archive'] == true ? 'selected="selected"':''?>><?=__('Yes')?> </option>
                                    <option value="false" <?=isset($cpt) && $cpt->args['has_archive'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Enables post type archives. Will use string as archive slug', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?=__('Rewrite', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite]" hideShowType="show" hideShowVal="" hideShowClasses="rewrite-field" class="hide-show sixty">
                                    <option value="true" <?=isset($cpt) && $cpt->args['rewrite'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt) && $cpt->args['rewrite'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="" <?=isset($cpt) && is_array($cpt->args['rewrite']) ? 'selected="selected"':''?>><?=__('Custom')?><?=isset($cpt) && is_string($cpt->args['rewrite']) ? ' [ '.$cpt->args['rewrite'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Rewrite permalinks with this format. Select custom for your own rewrite var, true for the default or false to prevent rewrite', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - Slug', 'kontrolwp')?></div>
                            <div class="field"><input type="text" name="args[rewrite][slug]" maxlength="20" value="<?=isset($cpt) ? $cpt->args['rewrite']['slug']:''?>" class="ninety" /></div>
                            <div class="desc"><?=__('A unique string to use before the post title in the permalink', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - With Front', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][with_front]" class="sixty">
                                    <option value="true" <?=isset($cpt->args['rewrite']['with_front']) && $cpt->args['rewrite']['with_front'] == true  ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['rewrite']['with_front']) && $cpt->args['rewrite']['with_front'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Allows permalinks to be prepended with front base (example: if your permalink structure is /blog/, then your links will be: false->/news/, true->/blog/news/)', 'kontrolwp')?></div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - Feeds', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][feeds]" class="sixty">
                                    <option value="true" <?=isset($cpt->args['rewrite']['feeds']) && $cpt->args['rewrite']['feeds'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['rewrite']['feeds']) && $cpt->args['rewrite']['feeds'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__("Whether the post type should have feeds for it's posts", 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?=__('Custom Rewrite - Pages', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][pages]" class="sixty">
                                    <option value="true" <?=isset($cpt->args['rewrite']['pages']) && $cpt->args['rewrite']['pages'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['rewrite']['pages']) && $cpt->args['rewrite']['pages'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Whether post type archive pages should be paginated. This is only useful if archives are enabled for this post type', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Query Variable', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[query_var]" class="custom-select sixty">
                                    <option value="true" <?=isset($cpt->args['query_var']) && $cpt->args['query_var'] == true ? 'selected="selected"':''?>><?=__('Use Post Type', 'kontrolwp')?></option>
                                    <option value="false" <?=isset($cpt->args['query_var']) && $cpt->args['query_var'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="<?=isset($cpt->args['query_var']) && is_string($cpt->args['query_var']) ? $cpt->args['query_var']:''?>" <?=isset($cpt) && is_string($cpt->args['query_var']) ? 'selected="selected"':''?> class="custom-val"  confirmText="<?=__('Please enter custom query variable', 'kontrolwp')?>:"><?=__('Custom', 'kontrolwp')?><?=isset($cpt) && is_string($cpt->args['query_var']) ? ' [ '.$cpt->args['query_var'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('False prevents queries or provide a custom string value to use for this post type', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?=__('Can Export', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[can_export]" class="sixty">
                                    <option value="true" <?=isset($cpt) && $cpt->args['can_export'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt) && $cpt->args['can_export'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Can this post_type be exported using the export/import feature?', 'kontrolwp')?></div>
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
                                    <option value="true" <?=isset($cpt->args['public']) && $cpt->args['public'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['public']) && $cpt->args['public'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Determines if post_type queries can be performed from the front end', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Show Admin UI', 'kontrolwp')?></div>
                            <div class="field">
                                <select id="show_ui_field" name="args[show_ui]" hideShowType="hide" hideShowVal="false" hideShowClasses="show_ui_field" class="hide-show sixty">
                                    <option value="true" <?=isset($cpt->args['show_ui']) && $cpt->args['show_ui'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['show_ui']) && $cpt->args['show_ui'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                             </div>
                            <div class="desc"><?=__('Whether to generate a default UI for managing this post type', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item show_ui_field">
                            <div class="label"><?=__('Show In Admin Menu', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_in_menu]" class="custom-select sixty" >
                                    <option value="true" <?=isset($cpt->args['show_in_menu']) && $cpt->args['show_in_menu'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt->args['show_in_menu']) && $cpt->args['show_in_menu'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="<?=isset($cpt->args['show_in_menu']) && is_string($cpt->args['show_in_menu']) ? $cpt->args['show_in_menu']:''?>" <?=isset($cpt) && is_string($cpt->args['show_in_menu']) ? 'selected="selected"':''?> class="custom-val" confirmText="<?=__('Please enter custom value', 'kontrolwp')?>:"><?=__('Custom', 'kontrolwp')?><?=isset($cpt) && is_string($cpt->args['show_in_menu']) ? ' [ '.$cpt->args['show_in_menu'].' ]':''?></option>
                                </select>
                            </div> 
                            <div class="desc"><?=__("If custom, must be a top level page like 'tools.php' or 'edit.php?post_type=page'",'kontrolwp')?>.</div>
                        </div>
                        <div class="item show_ui_field">
                            <div class="label"><?=__('Admin Menu Position','kontrolwp')?></div>
                            <div class="field">
                            	<? $set_positions = array(5,10,15,20,25,60,65,70,75,80,100); ?>
                                <select name="args[menu_position]" class="custom-select sixty" >
                                	<option value="100" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 100 ? 'selected="selected"':''?>>100 - <?=__('below second separator','kontrolwp')?></option>
                                    <option value="5" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 5 ? 'selected="selected"':''?>>5 - <?=__('below Posts','kontrolwp')?></option>
                                    <option value="10" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 10 ? 'selected="selected"':''?>>10 - <?=__('below Media','kontrolwp')?></option>
                                    <option value="15" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 15 ? 'selected="selected"':''?>>15 - <?=__('below Links','kontrolwp')?></option>
                                    <option value="20" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 20 ? 'selected="selected"':''?>>20 - <?=__('below Pages','kontrolwp')?></option>
                                    <option value="25" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 25 ? 'selected="selected"':''?>>25 - <?=__('below comments','kontrolwp')?></option>
                                    <option value="60" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 60 ? 'selected="selected"':''?>>60 - <?=__('below first separator','kontrolwp')?></option>
                                    <option value="65" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 65 ? 'selected="selected"':''?>>65 - <?=__('below Plugins','kontrolwp')?></option>
                                    <option value="70" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 70 ? 'selected="selected"':''?>>70 - <?=__('below Users','kontrolwp')?></option>
                                    <option value="75" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 75 ? 'selected="selected"':''?>>75 - <?=__('below Tools','kontrolwp')?></option>
                                    <option value="80" <?=isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 80 ? 'selected="selected"':''?>>80 - <?=__('below Settings','kontrolwp')?></option>
                                    <option value="<?=isset($cpt->args['menu_position']) && !in_array($cpt->args['menu_position'], $set_positions) ? $cpt->args['menu_position']:''?>" <?=isset($cpt) && !in_array($cpt->args['menu_position'], $set_positions) ? 'selected="selected"':''?> class="custom-val"  confirmText="<?=__('Please enter custom order value, must be a number','kontrolwp')?> eg. 50"><?=__('Custom','kontrolwp')?><?=isset($cpt) && !in_array($cpt->args['menu_position'], $set_positions) ? ' [ '.$cpt->args['menu_position'].' ]':''?></option>
                                </select>
                            </div> 
                            <div class="desc"><?=__('The position in the menu order the post type should appear','kontrolwp')?>.</div>
                        </div>
                         <div class="item show_ui_field">
                            <div class="label"><?=__('Admin Menu Icon','kontrolwp')?></div>
                            <div class="field">
                            
                            	<div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="args[menu_icon]" data-fileReturn="image_url"  data-fileGetData='<?=http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'thumbnail','image_dimensions_w'=>16,'image_dimensions_h'=>16,'image_dimensions'=>'enforce')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="250" data-fileTypes="{'<?=__('Images')?> (*.jpg, *.jpeg, *.gif, *.png)':'*.jpg; *.jpeg; *.gif; *.png'}">
                            		<input type="button" class="upload-el" value="<?=__('Upload Image','kontrolwp')?>" style="<?=isset($cpt->args['menu_icon']) && !empty($cpt->args['menu_icon']) ? 'display:none':''?>"  />
                                    <ul class="upload-list">
                                   	 <? if(isset($cpt->args['menu_icon']) && !empty($cpt->args['menu_icon'])) { ?>
                                    		<li class="file remove" id="file-1">
                                            	<div class="remove-file"></div>
                                            	<div class="file-image"><img src="<?=Kontrol_Tools::absolute_upload_path($cpt->args['menu_icon'])?>"></div>
                                                <input type="hidden" name="args[menu_icon]" value="<?=Kontrol_Tools::absolute_upload_path($cpt->args['menu_icon'])?>"></li>
                                     <? } ?>
                                    </ul>
                                    
                                </div>
                              
                               
                                
                            </div> 
                            <div class="desc"><?=__('Upload a custom menu icon. Size must be 16x16. Defaults to the posts menu icon','kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Show in Nav Menus','kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_in_nav_menus]" class="sixty" >
                                    <option value="true" <?=isset($cpt) && $cpt->args['show_in_nav_menus'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    <option value="false" <?=isset($cpt) && $cpt->args['show_in_nav_menus'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                </select>
                            </div> 
                            <div class="desc"><?=__('Whether this post type is available for selection in the Appearance -> Menus admin screen','kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
                     
            
            <div class="section collapsible">
              <div class="inside">
                <div class="title icon-menu-title">
                    <?=__('Capabilities','kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                    <div class="div"></div>
                 </div>
                
                <div class="section-content collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?=__('Capability Type','kontrolwp')?></div>
                            <div class="field">
                                <select name="args[capability_type]" class="custom-select sixty">
                                    <option value="post" <?=isset($cpt) && $cpt->args['capability_type'] == 'post' ? 'selected="selected"':''?>><?=__('Post')?></option>
                                    <option value="page" <?=isset($cpt) && $cpt->args['capability_type'] == 'page' ? 'selected="selected"':''?>><?=__('Page')?></option>
                                    <option value="<?=isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? $cpt->args['capability_type']:''?>" 
									<?=isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? 'selected="selected"':''?> class="custom-val"  confirmText="<?=__('Please enter custom capability type','kontrolwp')?>:"><?=__('Custom','kontrolwp')?>
									<?=isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? ' ['.$cpt->args['capability_type'].']':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__("Allows you to define a custom set of capabilities, which are permissions to edit, create, and read your custom post type. If you are unsure, leave this set to 'post'",'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?=__('Advanced Capabilities','kontrolwp')?></div>
                            <div class="field">
                                <select hideShowType="show" hideShowVal="true" hideShowClasses="adv-cap" class="hide-show sixty">
                                    <option value="false" <?=!isset($cpt->args['capabilities']['edit_post']) ? 'selected="selected"':''?>><?=__('No')?></option>
                                    <option value="true" <?=isset($cpt->args['capabilities']['edit_post']) ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                </select>
                            </div>
                            <div class="desc"><?=__('Use the default capabilities, or take full control over specific capability names','kontrolwp')?>.</div>
                        </div>
                         <div class="item adv-cap">
                            <div class="label"><?=__('Edit Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_post]" value="<?=isset($cpt->args['capabilities']['edit_post']) ? $cpt->args['capabilities']['edit_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Whether someone can create and edit a specific post of this post type','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Edit Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_posts]" value="<?=isset($cpt->args['capabilities']['edit_posts']) ? $cpt->args['capabilities']['edit_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability that allows editing posts of this post type','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Edit Other Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_others_posts]" value="<?=isset($cpt->args['capabilities']['edit_others_posts']) ? $cpt->args['capabilities']['edit_others_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability that allows editing of others posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Publish Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][publish_posts]"  value="<?=isset($cpt->args['capabilities']['publish_posts']) ? $cpt->args['capabilities']['publish_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability to grant publishing of these types of posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Read Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][read_post]"  value="<?=isset($cpt->args['capabilities']['read_post']) ? $cpt->args['capabilities']['read_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability that controls reading of a specific post of this post type','kontrolwp')?>.</div>
                        </div>
                         <div class="item adv-cap">
                            <div class="label"><?=__('Read Private Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][read_private_posts]" value="<?=isset($cpt->args['capabilities']['read_private_posts']) ? $cpt->args['capabilities']['read_private_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability to allow reading of private posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?=__('Delete Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][delete_post]" value="<?=isset($cpt->args['capabilities']['delete_post']) ? $cpt->args['capabilities']['delete_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?=__('Capability to allow reading of private posts','kontrolwp')?>.</div>
                        </div>
                        
                    </div>
                </div>
            </div>
           </div>
            
    </div><div class="half inline">
        <div class="section">
           <div class="inside">
            <div class="title icon-menu-title">
                <?=__('Labels','kontrolwp')?> <span class="tip"><?=__('various labels for the post type (all required)','kontrolwp')?></span>
                <div class="div"></div>
             </div>
            
            <div class="section-content">
                <div class="form-style">
                    <div class="item">
                        <div class="label"><?=__('Name (singular)','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][singular_name]" value="<?=isset($cpt) ? $cpt->args['labels']['singular_name']:''?>" class="auto-fill singular ninety required" /></div>
                        <div class="desc"><?=__('Singular version of the name','kontrolwp')?> - eg. <?=__('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Menu Name','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][menu_name]" value="<?=isset($cpt) ? $cpt->args['labels']['menu_name']:''?>" class="auto-fill plural ninety required" /></div>
                        <div class="desc"><?=__('The menu name text','kontrolwp')?> - eg. <?=__('Movies','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Add New','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_new]" value="<?=isset($cpt) ? $cpt->args['labels']['add_new']:''?>" appendLabelText="<?=__('Add New','kontrolwp')?>" class="auto-fill append  ninety required" /></div>
                        <div class="desc"><?=__('The add new text label - eg. Add New','kontrolwp')?></div>
                    </div>
                     <div class="item">
                        <div class="label"><?=__('Add New Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_new_item]" value="<?=isset($cpt) ? $cpt->args['labels']['add_new_item']:''?>"  appendLabelText="<?=__('Add New','kontrolwp')?>" class="auto-fill singular append  ninety required" /></div>
                        <div class="desc"><?=__('The add new item text - eg. Add New','kontrolwp')?> <?=__('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Edit Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][edit_item]" value="<?=isset($cpt) ? $cpt->args['labels']['edit_item']:''?>" appendLabelText="<?=__('Edit','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The edit item text - eg. Edit','kontrolwp')?> <?=__('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('New Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][new_item]" value="<?=isset($cpt) ? $cpt->args['labels']['new_item']:''?>" appendLabelText="<?=__('New','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The new item text - eg. New','kontrolwp')?> <?=__('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('View Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][view_item]" value="<?=isset($cpt) ? $cpt->args['labels']['view_item']:''?>" appendLabelText="<?=__('View','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('The view item text - eg. View','kontrolwp')?> <?=__('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Search Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][search_items]" value="<?=isset($cpt) ? $cpt->args['labels']['search_items']:''?>" appendLabelText="<?=__('Search','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('Searching for an item text - eg. Search','kontrolwp')?> <?=__('Movies','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Not Found','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][not_found]" value="<?=isset($cpt) ? $cpt->args['labels']['not_found']:''?>" appendLabelText="<?=__('No')?> [] <?=__('found','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('Not found text - eg. No movies found','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Not Found In Trash','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][not_found_in_trash]" value="<?=isset($cpt) ? $cpt->args['labels']['not_found_in_trash']:''?>" appendLabelText="<?=__('No')?> [] <?=__('found in trash','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?=__('Not found in trash text - eg. No movies found in trash','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Parent Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][parent_item_colon]" value="<?=isset($cpt) ? $cpt->args['labels']['parent_item_colon']:''?>" appendLabelText="<?=__('Parent','kontrolwp')?> []:" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?=__('How the parent item is referred to - eg. Parent movie:','kontrolwp')?></div>
                    </div>
  
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<input type="hidden" name="active" value="<?=isset($cpt) ? $cpt->active:'1'?>" />
<input type="hidden" name="sort_order" value="<?=isset($cpt) ? $cpt->sort_order:''?>" />

 <!-- Side Col -->
<div class="side-col inline">
	
    
    <?php $this->renderElement('cpt-'.$action.'-side-col', array('controller_url' => $controller_url, 'pt_count' => $pt_count)); ?>
</div>

</form>