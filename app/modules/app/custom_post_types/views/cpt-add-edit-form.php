<?php $current_user = wp_get_current_user(); ?>

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
                'file_size_max': <?php echo Kontrol_Tools::return_post_max('bytes')?>,
                'app_path': '<?php echo URL_PLUGIN?>'
            });     
        
         // Validation.
            new Form.Validator.Inline('post-type-add');
        
         <?php if($action == 'edit') { ?>
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
         <?php } ?>
    });
</script>



<form id="post-type-add" action="<?php echo $controller_url?>/save/<?php echo isset($cpt) ? $cpt->id:''?>&noheader=true" method="POST">

<!-- Main Col -->
<div class="main-col inline">
    <div class="half inline">
        <div class="section">
            <div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Settings')?> <span class="tip"><?php echo __('start here to automatically populate the form','kontrolwp')?></span>
                    
                    <div class="div"></div>
                 </div>
                <div class="section-content">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?php echo __('Post Type ID', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="key" name="key" value="<?php echo isset($cpt) ? $cpt->cpt_key:''?>" maxlength="20" data-error-msg="<?php echo __('This post type ID already exists, please enter another','kontrolwp')?>." class="required ninety safe-chars" /></div>
                            <input type="hidden" id="cpts" value='<?php echo json_encode(str_replace(isset($cpt) ? $cpt->cpt_key:'','',get_post_types()))?>' />
                            <div class="desc"><?php echo __('Max. 20 characters, cannot contain capital letters or spaces', 'kontrolwp')?>.</div>
                        </div>
                        <?php if($action == 'edit') { ?>
                        <div id="update-key-field" class="item" style="display: none">
                            <div class="label"><input type="checkbox" id="current-key" name="current-key" value="<?php echo isset($cpt) ? $cpt->cpt_key:''?>" checked="checked" /> <?php echo __('Update current posts attached to post type?', 'kontrolwp')?></div>
                            <div class="desc"><?php echo __('If this post type already has posts attached to it and you change the post type ID they will be lost, check the box above to make sure those posts get updated to match the new ID', 'kontrolwp')?>.</div>
                        </div>
                        <?php } ?>
                        <div class="item">
                            <div class="label"><?php echo __('Name (plural)', 'kontrolwp')?> <span class="req-ast">*</span></div>
                            <div class="field"><input type="text" id="post-name" name="args[labels][name]" value="<?php echo isset($cpt) ? $cpt->args['labels']['name']:''?>" class="required ninety" /></div>
                            <div class="desc"><?php echo __('General name for the post type, usually plural - eg. Movies', 'kontrolwp')?></div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Description')?></div>
                            <div class="field"><textarea name="args[description]" class="ninety"><?php echo isset($cpt) ? $cpt->args['description']:''?></textarea></div>
                            <div class="desc"><?php echo __('A short descriptive summary of what the post type is', 'kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="section collapsible">
           <div class="inside">
            <div class="title icon-menu-title">
               <?php echo __('Supported Taxonomies &amp; Features', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                <div class="div"></div>
             </div>
             
             <div class="section-content collapsible-section">
                <div class="form-style">
                    <div class="item">
                        <div class="kontrol-select-add">
                            <div class="label"><?php echo __('Add Taxonomies', 'kontrolwp')?></div>
                            <div class="field">
                                <select nameToAdd="args[taxonomies][]" class="sixty">
                                    <option value=""><b><?php echo __('Native', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <?php foreach($tax_native as $tax) { ?>
                                          <option value="<?php echo $tax->tax_key?>"><?php echo $tax->name?></option>                             
                                    <?php } ?>
                                    <option value="">-------------------</option>
                                    <option value=""><b><?php echo __('Custom', 'kontrolwp')?></b></option>
                                    <option value="">-------------------</option>
                                    <?php if(!empty($tax_custom)) { ?>
                                         <?php foreach($tax_custom as $tax) { ?>
                                        <option value="<?php echo $tax->tax_key?>"><?php echo $tax->name?></option>     
                                        <?php } ?>           
                                    <?php }else{ ?>
                                    <option value=""><?php echo __('No custom taxonomies found', 'kontrolwp')?></option>
                                    <?php } ?>
                                </select>
                            </div>
                             <div class="kontrol-select-results">
                                  <?php if(isset($attached_taxonomies)) {
                                                foreach($attached_taxonomies as $pt) { ?>
                                                    <div class="feature"><?php echo $pt->tax_name?> <input type="hidden" name="args[taxonomies][]" value="<?php echo $pt->tax_key?>" /></div>
                                        <?php }
                                        
                                  } ?>
            
                             </div>
                        </div>
                    </div>
               
                    <div class="item">
                        <div class="kontrol-select-add">
                            <div class="label"><?php echo __('Add Features', 'kontrolwp')?></div>
                            <div class="field">
                                <input type="hidden" name="args[supports][]" value="" />
                                <select nameToAdd="args[supports][]" class="sixty">
                                    <option value=""><?php echo __('Choose', 'kontrolwp')?>...</option>
                                    <option value="">-------------------</option>
                                    <option value="title"><?php echo __('Title')?></option>
                                    <option value="editor"><?php echo __('Editor')?></option>
                                    <option value="page-attributes"><?php echo __('Page Attributes')?></option>
                                    <option value="excerpt"><?php echo __('Excerpt')?></option>
                                    <option value="author"><?php echo __('Author')?></option>
                                    <option value="thumbnail"><?php echo __('Thumbnail')?></option>
                                    <option value="trackbacks"><?php echo __('Trackbacks')?></option>
                                    <option value="custom-fields"><?php echo __('Custom Fields')?></option>
                                    <option value="comments"><?php echo __('Comments')?></option>
                                    <option value="revisions"><?php echo __('Revisions')?></option>
                                    <option value="post-formats"><?php echo __('Post Formats')?></option>
                                </select>
                            </div>
                             <div class="kontrol-select-results">
                            <?php if(isset($cpt)) {
                                    if(is_array($cpt->args['supports'])) { 
                                        sort($cpt->args['supports']);
                                        foreach( $cpt->args['supports'] as $support) { 
                                            if(!empty($support)) { ?>
                                            <div class="feature"><?php echo ucwords(str_replace('-', ' ',$support))?> <input type="hidden" name="args[supports][]" value="<?php echo $support?>" /></div>
                                <?php      }
                                        }
                                } ?>
                            <?php }else{ ?>
                                    <div class="feature"><?php echo __('Title')?> <input type="hidden" name="args[supports][]" value="title" /></div>
                                    <div class="feature"><?php echo __('Editor')?> (wysiwyg)<input type="hidden" name="args[supports][]" value="editor" /></div>
                            <?php } ?>
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
                    <?php echo __('Advanced Settings', 'kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                    <div class="div"></div>
                 </div>
                
                <div class="section-content collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?php echo __('Hierarchical', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[hierarchical]" class="sixty">
                                    <option value="true" <?php echo isset($cpt) && $cpt->args['hierarchical'] == true ? 'selected="selected"':''?>><?php echo __('True (similar to a page)', 'kontrolwp')?></option>
                                    <option value="false" <?php echo isset($cpt) && $cpt->args['hierarchical'] == false ? 'selected="selected"':''?>><?php echo __('False (similar to a post)', 'kontrolwp')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Whether the post type is hierarchical. Allows Parent to be specified', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Has Archive', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[has_archive]" class="sixty">
                                    <option value="true" <?php echo isset($cpt) && $cpt->args['has_archive'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?> </option>
                                    <option value="false" <?php echo isset($cpt) && $cpt->args['has_archive'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Enables post type archives. Will use string as archive slug', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?php echo __('Rewrite', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite]" hideShowType="show" hideShowVal="" hideShowClasses="rewrite-field" class="hide-show sixty">
                                    <option value="true" <?php echo isset($cpt) && $cpt->args['rewrite'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt) && $cpt->args['rewrite'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                    <option value="" <?php echo isset($cpt) && is_array($cpt->args['rewrite']) ? 'selected="selected"':''?>><?php echo __('Custom')?><?php echo isset($cpt) && is_string($cpt->args['rewrite']) ? ' [ '.$cpt->args['rewrite'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Rewrite permalinks with this format. Select custom for your own rewrite var, true for the default or false to prevent rewrite', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?php echo __('Custom Rewrite - Slug', 'kontrolwp')?></div>
                            <div class="field"><input type="text" name="args[rewrite][slug]" maxlength="20" value="<?php echo isset($cpt) ? $cpt->args['rewrite']['slug']:''?>" class="ninety" /></div>
                            <div class="desc"><?php echo __('A unique string to use before the post title in the permalink', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?php echo __('Custom Rewrite - With Front', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][with_front]" class="sixty">
                                    <option value="true" <?php echo isset($cpt->args['rewrite']['with_front']) && $cpt->args['rewrite']['with_front'] == true  ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['rewrite']['with_front']) && $cpt->args['rewrite']['with_front'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Allows permalinks to be prepended with front base (example: if your permalink structure is /blog/, then your links will be: false->/news/, true->/blog/news/)', 'kontrolwp')?></div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?php echo __('Custom Rewrite - Feeds', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][feeds]" class="sixty">
                                    <option value="true" <?php echo isset($cpt->args['rewrite']['feeds']) && $cpt->args['rewrite']['feeds'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['rewrite']['feeds']) && $cpt->args['rewrite']['feeds'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __("Whether the post type should have feeds for it's posts", 'kontrolwp')?>.</div>
                        </div>
                        <div class="item rewrite-field">
                            <div class="label"><?php echo __('Custom Rewrite - Pages', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[rewrite][pages]" class="sixty">
                                    <option value="true" <?php echo isset($cpt->args['rewrite']['pages']) && $cpt->args['rewrite']['pages'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['rewrite']['pages']) && $cpt->args['rewrite']['pages'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Whether post type archive pages should be paginated. This is only useful if archives are enabled for this post type', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Query Variable', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[query_var]" class="custom-select sixty">
                                    <option value="true" <?php echo isset($cpt->args['query_var']) && $cpt->args['query_var'] == true ? 'selected="selected"':''?>><?php echo __('Use Post Type', 'kontrolwp')?></option>
                                    <option value="false" <?php echo isset($cpt->args['query_var']) && $cpt->args['query_var'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                    <option value="<?php echo isset($cpt->args['query_var']) && is_string($cpt->args['query_var']) ? $cpt->args['query_var']:''?>" <?php echo isset($cpt) && is_string($cpt->args['query_var']) ? 'selected="selected"':''?> class="custom-val"  confirmText="<?php echo __('Please enter custom query variable', 'kontrolwp')?>:"><?php echo __('Custom', 'kontrolwp')?><?php echo isset($cpt) && is_string($cpt->args['query_var']) ? ' [ '.$cpt->args['query_var'].' ]':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('False prevents queries or provide a custom string value to use for this post type', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item">
                            <div class="label"><?php echo __('Can Export', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[can_export]" class="sixty">
                                    <option value="true" <?php echo isset($cpt) && $cpt->args['can_export'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt) && $cpt->args['can_export'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Can this post_type be exported using the export/import feature?', 'kontrolwp')?></div>
                        </div>
                        
                    </div>
                </div>
            </div>
       </div>
            
        <div class="section collapsible">
             <div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Visibility', 'kontrolwp')?> <div class="button-collapse toggle-collapse expand"></div>
                    <div class="div"></div>
                 </div>
                
                <div class="section-content  collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?php echo __('Public', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[public]" class="sixty">
                                    <option value="true" <?php echo isset($cpt->args['public']) && $cpt->args['public'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['public']) && $cpt->args['public'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Determines if post_type queries can be performed from the front end', 'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Show Admin UI', 'kontrolwp')?></div>
                            <div class="field">
                                <select id="show_ui_field" name="args[show_ui]" hideShowType="hide" hideShowVal="false" hideShowClasses="show_ui_field" class="hide-show sixty">
                                    <option value="true" <?php echo isset($cpt->args['show_ui']) && $cpt->args['show_ui'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['show_ui']) && $cpt->args['show_ui'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                             </div>
                            <div class="desc"><?php echo __('Whether to generate a default UI for managing this post type', 'kontrolwp')?>.</div>
                        </div>
                         <div class="item show_ui_field">
                            <div class="label"><?php echo __('Show In Admin Menu', 'kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_in_menu]" class="custom-select sixty" >
                                    <option value="true" <?php echo isset($cpt->args['show_in_menu']) && $cpt->args['show_in_menu'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt->args['show_in_menu']) && $cpt->args['show_in_menu'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                    <option value="<?php echo isset($cpt->args['show_in_menu']) && is_string($cpt->args['show_in_menu']) ? $cpt->args['show_in_menu']:''?>" <?php echo isset($cpt) && is_string($cpt->args['show_in_menu']) ? 'selected="selected"':''?> class="custom-val" confirmText="<?php echo __('Please enter custom value', 'kontrolwp')?>:"><?php echo __('Custom', 'kontrolwp')?><?php echo isset($cpt) && is_string($cpt->args['show_in_menu']) ? ' [ '.$cpt->args['show_in_menu'].' ]':''?></option>
                                </select>
                            </div> 
                            <div class="desc"><?php echo __("If custom, must be a top level page like 'tools.php' or 'edit.php?post_type=page'",'kontrolwp')?>.</div>
                        </div>
                        <div class="item show_ui_field">
                            <div class="label"><?php echo __('Admin Menu Position','kontrolwp')?></div>
                            <div class="field">
                                <?php $set_positions = array(5,10,15,20,25,60,65,70,75,80,100); ?>
                                <select name="args[menu_position]" class="custom-select sixty" >
                                    <option value="100" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 100 ? 'selected="selected"':''?>>100 - <?php echo __('below second separator','kontrolwp')?></option>
                                    <option value="5" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 5 ? 'selected="selected"':''?>>5 - <?php echo __('below Posts','kontrolwp')?></option>
                                    <option value="10" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 10 ? 'selected="selected"':''?>>10 - <?php echo __('below Media','kontrolwp')?></option>
                                    <option value="15" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 15 ? 'selected="selected"':''?>>15 - <?php echo __('below Links','kontrolwp')?></option>
                                    <option value="20" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 20 ? 'selected="selected"':''?>>20 - <?php echo __('below Pages','kontrolwp')?></option>
                                    <option value="25" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 25 ? 'selected="selected"':''?>>25 - <?php echo __('below comments','kontrolwp')?></option>
                                    <option value="60" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 60 ? 'selected="selected"':''?>>60 - <?php echo __('below first separator','kontrolwp')?></option>
                                    <option value="65" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 65 ? 'selected="selected"':''?>>65 - <?php echo __('below Plugins','kontrolwp')?></option>
                                    <option value="70" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 70 ? 'selected="selected"':''?>>70 - <?php echo __('below Users','kontrolwp')?></option>
                                    <option value="75" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 75 ? 'selected="selected"':''?>>75 - <?php echo __('below Tools','kontrolwp')?></option>
                                    <option value="80" <?php echo isset($cpt->args['menu_position']) && $cpt->args['menu_position'] == 80 ? 'selected="selected"':''?>>80 - <?php echo __('below Settings','kontrolwp')?></option>
                                    <option value="<?php echo isset($cpt->args['menu_position']) && !in_array($cpt->args['menu_position'], $set_positions) ? $cpt->args['menu_position']:''?>" <?php echo isset($cpt) && !in_array($cpt->args['menu_position'], $set_positions) ? 'selected="selected"':''?> class="custom-val"  confirmText="<?php echo __('Please enter custom order value, must be a number','kontrolwp')?> eg. 50"><?php echo __('Custom','kontrolwp')?><?php echo isset($cpt) && !in_array($cpt->args['menu_position'], $set_positions) ? ' [ '.$cpt->args['menu_position'].' ]':''?></option>
                                </select>
                            </div> 
                            <div class="desc"><?php echo __('The position in the menu order the post type should appear','kontrolwp')?>.</div>
                        </div>
                         <div class="item show_ui_field">
                            <div class="label"><?php echo __('Admin Menu Icon','kontrolwp')?></div>
                            <div class="field">
                            
                                <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="args[menu_icon]" data-fileReturn="image_url"  data-fileGetData='<?php echo http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'thumbnail','image_dimensions_w'=>16,'image_dimensions_h'=>16,'image_dimensions'=>'enforce')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="250" data-fileTypes="{'<?php echo __('Images')?> (*.jpg, *.jpeg, *.gif, *.png)':'*.jpg; *.jpeg; *.gif; *.png'}">
                                    <input type="button" class="upload-el" value="<?php echo __('Upload Image','kontrolwp')?>" style="<?php echo isset($cpt->args['menu_icon']) && !empty($cpt->args['menu_icon']) ? 'display:none':''?>"  />
                                    <ul class="upload-list">
                                     <?php if(isset($cpt->args['menu_icon']) && !empty($cpt->args['menu_icon'])) { ?>
                                            <li class="file remove" id="file-1">
                                                <div class="remove-file"></div>
                                                <div class="file-image"><img src="<?php echo Kontrol_Tools::absolute_upload_path($cpt->args['menu_icon'])?>"></div>
                                                <input type="hidden" name="args[menu_icon]" value="<?php echo Kontrol_Tools::absolute_upload_path($cpt->args['menu_icon'])?>"></li>
                                     <?php } ?>
                                    </ul>
                                    
                                </div>
                              
                               
                                
                            </div> 
                            <div class="desc"><?php echo __('Upload a custom menu icon. Size must be 16x16. Defaults to the posts menu icon','kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Show in Nav Menus','kontrolwp')?></div>
                            <div class="field">
                                <select name="args[show_in_nav_menus]" class="sixty" >
                                    <option value="true" <?php echo isset($cpt) && $cpt->args['show_in_nav_menus'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    <option value="false" <?php echo isset($cpt) && $cpt->args['show_in_nav_menus'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                </select>
                            </div> 
                            <div class="desc"><?php echo __('Whether this post type is available for selection in the Appearance -> Menus admin screen','kontrolwp')?>.</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
                     
            
            <div class="section collapsible">
              <div class="inside">
                <div class="title icon-menu-title">
                    <?php echo __('Capabilities','kontrolwp')?>  <div class="button-collapse toggle-collapse expand"></div> 
                    <div class="div"></div>
                 </div>
                
                <div class="section-content collapsible-section">
                    <div class="form-style">
                        <div class="item">
                            <div class="label"><?php echo __('Capability Type','kontrolwp')?></div>
                            <div class="field">
                                <select name="args[capability_type]" class="custom-select sixty">
                                    <option value="post" <?php echo isset($cpt) && $cpt->args['capability_type'] == 'post' ? 'selected="selected"':''?>><?php echo __('Post')?></option>
                                    <option value="page" <?php echo isset($cpt) && $cpt->args['capability_type'] == 'page' ? 'selected="selected"':''?>><?php echo __('Page')?></option>
                                    <option value="<?php echo isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? $cpt->args['capability_type']:''?>" 
                                    <?php echo isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? 'selected="selected"':''?> class="custom-val"  confirmText="<?php echo __('Please enter custom capability type','kontrolwp')?>:"><?php echo __('Custom','kontrolwp')?>
                                    <?php echo isset($cpt) && $cpt->args['capability_type'] != 'post' && $cpt->args['capability_type'] != 'page' ? ' ['.$cpt->args['capability_type'].']':''?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __("Allows you to define a custom set of capabilities, which are permissions to edit, create, and read your custom post type. If you are unsure, leave this set to 'post'",'kontrolwp')?>.</div>
                        </div>
                        <div class="item">
                            <div class="label"><?php echo __('Advanced Capabilities','kontrolwp')?></div>
                            <div class="field">
                                <select hideShowType="show" hideShowVal="true" hideShowClasses="adv-cap" class="hide-show sixty">
                                    <option value="false" <?php echo !isset($cpt->args['capabilities']['edit_post']) ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                    <option value="true" <?php echo isset($cpt->args['capabilities']['edit_post']) ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                </select>
                            </div>
                            <div class="desc"><?php echo __('Use the default capabilities, or take full control over specific capability names','kontrolwp')?>.</div>
                        </div>
                         <div class="item adv-cap">
                            <div class="label"><?php echo __('Edit Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_post]" value="<?php echo isset($cpt->args['capabilities']['edit_post']) ? $cpt->args['capabilities']['edit_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Whether someone can create and edit a specific post of this post type','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?php echo __('Edit Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_posts]" value="<?php echo isset($cpt->args['capabilities']['edit_posts']) ? $cpt->args['capabilities']['edit_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability that allows editing posts of this post type','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?php echo __('Edit Other Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][edit_others_posts]" value="<?php echo isset($cpt->args['capabilities']['edit_others_posts']) ? $cpt->args['capabilities']['edit_others_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability that allows editing of others posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?php echo __('Publish Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][publish_posts]"  value="<?php echo isset($cpt->args['capabilities']['publish_posts']) ? $cpt->args['capabilities']['publish_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability to grant publishing of these types of posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?php echo __('Read Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][read_post]"  value="<?php echo isset($cpt->args['capabilities']['read_post']) ? $cpt->args['capabilities']['read_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability that controls reading of a specific post of this post type','kontrolwp')?>.</div>
                        </div>
                         <div class="item adv-cap">
                            <div class="label"><?php echo __('Read Private Posts Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][read_private_posts]" value="<?php echo isset($cpt->args['capabilities']['read_private_posts']) ? $cpt->args['capabilities']['read_private_posts']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability to allow reading of private posts','kontrolwp')?>.</div>
                        </div>
                        <div class="item adv-cap">
                            <div class="label"><?php echo __('Delete Post Capability','kontrolwp')?></div>
                            <div class="field">
                                <input type="text" name="args[capabilities][delete_post]" value="<?php echo isset($cpt->args['capabilities']['delete_post']) ? $cpt->args['capabilities']['delete_post']:''?>" class="ninety">
                            </div>
                            <div class="desc"><?php echo __('Capability to allow reading of private posts','kontrolwp')?>.</div>
                        </div>
                        
                    </div>
                </div>
            </div>
           </div>
            
    </div><div class="half inline">
        <div class="section">
           <div class="inside">
            <div class="title icon-menu-title">
                <?php echo __('Labels','kontrolwp')?> <span class="tip"><?php echo __('various labels for the post type (all required)','kontrolwp')?></span>
                <div class="div"></div>
             </div>
            
            <div class="section-content">
                <div class="form-style">
                    <div class="item">
                        <div class="label"><?php echo __('Name (singular)','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][singular_name]" value="<?php echo isset($cpt) ? $cpt->args['labels']['singular_name']:''?>" class="auto-fill singular ninety required" /></div>
                        <div class="desc"><?php echo __('Singular version of the name','kontrolwp')?> - eg. <?php echo __('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Menu Name','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][menu_name]" value="<?php echo isset($cpt) ? $cpt->args['labels']['menu_name']:''?>" class="auto-fill plural ninety required" /></div>
                        <div class="desc"><?php echo __('The menu name text','kontrolwp')?> - eg. <?php echo __('Movies','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Add New','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_new]" value="<?php echo isset($cpt) ? $cpt->args['labels']['add_new']:''?>" appendLabelText="<?php echo __('Add New','kontrolwp')?>" class="auto-fill append  ninety required" /></div>
                        <div class="desc"><?php echo __('The add new text label - eg. Add New','kontrolwp')?></div>
                    </div>
                     <div class="item">
                        <div class="label"><?php echo __('Add New Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][add_new_item]" value="<?php echo isset($cpt) ? $cpt->args['labels']['add_new_item']:''?>"  appendLabelText="<?php echo __('Add New','kontrolwp')?>" class="auto-fill singular append  ninety required" /></div>
                        <div class="desc"><?php echo __('The add new item text - eg. Add New','kontrolwp')?> <?php echo __('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Edit Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][edit_item]" value="<?php echo isset($cpt) ? $cpt->args['labels']['edit_item']:''?>" appendLabelText="<?php echo __('Edit','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?php echo __('The edit item text - eg. Edit','kontrolwp')?> <?php echo __('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('New Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][new_item]" value="<?php echo isset($cpt) ? $cpt->args['labels']['new_item']:''?>" appendLabelText="<?php echo __('New','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?php echo __('The new item text - eg. New','kontrolwp')?> <?php echo __('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('View Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][view_item]" value="<?php echo isset($cpt) ? $cpt->args['labels']['view_item']:''?>" appendLabelText="<?php echo __('View','kontrolwp')?>" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?php echo __('The view item text - eg. View','kontrolwp')?> <?php echo __('Movie','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Search Items','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][search_items]" value="<?php echo isset($cpt) ? $cpt->args['labels']['search_items']:''?>" appendLabelText="<?php echo __('Search','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?php echo __('Searching for an item text - eg. Search','kontrolwp')?> <?php echo __('Movies','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Not Found','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][not_found]" value="<?php echo isset($cpt) ? $cpt->args['labels']['not_found']:''?>" appendLabelText="<?php echo __('No')?> [] <?php echo __('found','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?php echo __('Not found text - eg. No movies found','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Not Found In Trash','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][not_found_in_trash]" value="<?php echo isset($cpt) ? $cpt->args['labels']['not_found_in_trash']:''?>" appendLabelText="<?php echo __('No')?> [] <?php echo __('found in trash','kontrolwp')?>" class="auto-fill plural append ninety required" /></div>
                        <div class="desc"><?php echo __('Not found in trash text - eg. No movies found in trash','kontrolwp')?></div>
                    </div>
                    <div class="item">
                        <div class="label"><?php echo __('Parent Item','kontrolwp')?></div>
                        <div class="field"><input type="text" name="args[labels][parent_item_colon]" value="<?php echo isset($cpt) ? $cpt->args['labels']['parent_item_colon']:''?>" appendLabelText="<?php echo __('Parent','kontrolwp')?> []:" class="auto-fill singular append ninety required" /></div>
                        <div class="desc"><?php echo __('How the parent item is referred to - eg. Parent movie:','kontrolwp')?></div>
                    </div>
  
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<input type="hidden" name="active" value="<?php echo isset($cpt) ? $cpt->active:'1'?>" />
<input type="hidden" name="sort_order" value="<?php echo isset($cpt) ? $cpt->sort_order:''?>" />

 <!-- Side Col -->
<div class="side-col inline">
    
    
    <?php $this->renderElement('cpt-'.$action.'-side-col', array('controller_url' => $controller_url, 'pt_count' => $pt_count)); ?>
</div>

</form>