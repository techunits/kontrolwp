<?php $current_user = wp_get_current_user(); ?>

<script type="text/javascript">

	window.addEvent('domready', function() {		
			// Mootools for managing the tables
			new kontrol_custom_settings_manage({
				'ajax_url':'<?php echo $controller_url?>' 
			});
			
			new kontrol_file_upload({
					'file_size_max': <?php echo Kontrol_Tools::return_post_max('bytes')?>,
					'app_path': '<?php echo URL_PLUGIN?>'
			});	
			// Makes the rows sortable
			new sort_rows();
			new kontrol_collapse_show();
			
			// Validation.
  			fields_validator = new Form.Validator.Inline('cs-settings-add');
	});
	
</script>


<!-- Main Col -->
<div id="group-rows" class="main-col inline">
   <div class="half inline"> 
	<div class="section">
            <div class="inside">
                <div class="title"><?php echo __('Custom Settings Groups','kontrolwp')?></div>
            </div>
     </div>
	<?php 
	$group_count = 0;
	
	if(isset($post_types) && count($post_types) > 0) {
		

		foreach($post_types as $pt_key => $pt) { 
			if(isset($groups[$pt_key])) {
				$group_count++;
	?>
        <div class="section">
            <div class="inside">
                <div class="title"><?php echo $post_types[$pt_key]['label']?></div>
                <div class="rows sortable">
                    <?php foreach($groups[$pt_key] as $group) { ?>
                    	<div id="<?php echo $group->id?>" data-id="<?php echo $group->id?>" data-group-id="<?php echo $group->group_id?>" sortAction="<?php echo $controller_url?>/updateGroupOrder/<?php echo $group->id?>/" class="row <?php echo empty($group->active) ? 'field-hidden':''?>">
                            <div class="inline tab drag-row"></div>
                            <div title="Name" style="width: 25%;  top: 4px;" class="inline cpt-name">
                                <b><a href="<?php echo $controller_url?>/edit/<?php echo $group->group_id?>"><?php echo $group->group_name?></a></b>
                            </div>
                            <div title="Field Count" style="width: 15%; top: 4px;" class="inline"><b><?php echo $group->field_count?></b> <?php echo __('Fields','kontrolwp')?></div>
                            <div title="Position" style="width: 15%; top: 4px;" class="inline"></div>
                            <div title="Options" style="width: 21%; text-align: center;" class="inline cpt-options">
                                <a href="<?php echo $controller_url?>/edit/<?php echo $group->group_id?>"><img class="edit-field" alt="<?php echo __('Edit','kontrolwp')?>" title="<?php echo __('Edit','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-edit.png" style="cursor: pointer"></a> &nbsp;
                                <img class="hide-field" alt="<?php echo __('Hide','kontrolwp')?>" title="<?php echo __('Hide','kontrolwp')?>" src="<?php echo URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
                                
                            </div>
                    	</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 		}
		}
	} ?>
    
   <?php if($group_count == 0) { ?>
   
  		<div class="section">
            <div class="inside">
                <div class="title"><?php echo __('Getting Started','kontrolwp')?></div>
                <div class="form-style">
                    <div class="item">
                        <div class="desc" style="font-size: 12px">
                        	<?php echo __("Custom settings allow you to use the power of our custom fields module to create your own sets of custom options for your CMS. These are highly useful for creating and storing information / images / files that don't need to be tied to any post.",'kontrolwp')?>
                        	<p>
							<?php echo __("As an example, say you need to display a company logo image across several different sections of your clients CMS. Instead of hard coding that image into several places, you can create a custom setting image field, upload the image there, then display that image anywhere across the site by simply retrieving that setting using the Kontrol <b>kwp_get_setting('insert-your-field-key')</b> function. Then to update the logo, just change the image in the custom settings page and the new logo is automatically shown across the whole site without the need to touch any HTML or code.",'kontrolwp')?>
                            </p>
                            <p>
                            <?php echo __("These custom settings allow you to create a very complete and flexible CMS solution for your clients.",'kontrolwp')?>
							</p>
                        </div>
                    </div> 
                 </div>
            </div>
        </div>
   <?php } ?>
   
    
   </div>
     <div class="half inline">
      <div class="section">
      	 <form id="cs-settings-add" action="<?php echo $controller_url?>/saveSettings&noheader=true" method="POST">
     	<div class="inside">
            <div class="title"><?php echo __('Custom Settings Config','kontrolwp')?></div>
     			<div id="categories-settings-config" class="section-content collapsible-section">
                    <div class="form-style">
                    	<div>
                            <div class="item">
                                 <div class="label"><?php echo __('Admin Menu Enabled','kontrolwp')?></div>
                                 <div class="field">
                                    <select name="settings[enabled]" class="ninety">
                                    	<option value="false" <?php echo isset($cs_settings['enabled']) && $cs_settings['enabled'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                                        <option value="true" <?php echo isset($cs_settings['enabled']) && $cs_settings['enabled'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                                    </select>
                                 </div>
                                <div class="desc"><?php echo __('Enable access to the settings page via the admin menu','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div style="width:72%" class="inline">
                            <div class="item">
                                 <div class="label"><?php echo __('Admin Menu Name','kontrolwp')?></div>
                                 <div class="field"><input type="text" id="settings-name" name="settings[name]" value="<?php echo isset($cs_settings['name']) ? htmlentities($cs_settings['name'], ENT_QUOTES):'Site Options'?>" class="required ninety" /></div>
                                <div class="desc"><?php echo __('The label for the settings admin menu entry','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div style="width:25%" class="inline">
                            <div class="item show_ui_field">
                                <div class="label"><?php echo __('Admin Menu Icon','kontrolwp')?></div>
                                <div class="field">
                                
                                    <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="settings[menu_icon]" data-fileReturn="image_url" data-fileGetData='<?php echo http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'thumbnail','image_dimensions_w'=>16,'image_dimensions_h'=>16,'image_dimensions'=>'enforce')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="250" data-fileTypes="{'<?php echo __('Images')?> (*.jpg, *.jpeg, *.gif, *.png)':'*.jpg; *.jpeg; *.gif; *.png'}">
                                        <input type="button" class="upload-el" value="<?php echo __('Upload Image','kontrolwp')?>" style="<?php echo isset($cs_settings['menu_icon']) && !empty($cs_settings['menu_icon']) ? 'display:none':''?>"  />
                                        <ul class="upload-list">
                                         <?php if(isset($cs_settings['menu_icon']) && !empty($cs_settings['menu_icon'])) { ?>
                                                <li class="file remove" id="file-1" style="margin-bottom: 0; padding-bottom: 0">
                                                    <div class="remove-file"></div>
                                                    <div class="file-image"><img src="<?php echo $cs_settings['menu_icon']?>"></div>
                                                    <input type="hidden" name="settings[menu_icon]" value="<?php echo $cs_settings['menu_icon']?>"></li>
                                         <?php } ?>
                                        </ul>
                                        
                                    </div>
                                </div> 
                                <div class="desc">16x16 <?php echo __('menu icon','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div class="item">
                        	<div class="label" style="margin-top: 10px;"><?php echo __('Settings Categories','kontrolwp')?></div>
                        	<div id="settings-cats" data-auto-add-row="true" class="kontrol-smart-box">

                                <div class="section">
                                    <div class="inside">
                                        <div class="col-title">
                                        			<div class="inline" style="width: 49px"></div>
                                                     <div style="width: 25%; padding-left: 1%;" class="inline">
                                                        <div class="label"><?php echo __('Title')?> <span class="req-ast">*</span></div>
                                                        <div class="desc"><?php echo __('Category name and its submenu name','kontrolwp')?>.</div>
                                                    </div>
                                                    <div style="width: 60%; padding-left: 1%;" class="inline">
                                                        <div class="label"><?php echo __('Description / Instructions','kontrolwp')?></div>
                                                        <div class="desc"><?php echo __('Provide instructions or just a description of what these settings are used for on the site','kontrolwp')?>.</div>
                                                    </div>
                                        </div>
            
                                        <div class="rows sortable">
                                            <div class="row new-row">
                                                    <div class="inline tab drag-row"></div>
                                                	<div style="width: 25%; padding-left: 1%;" class="field inline"><input type="text" class="required ninety" name="settings[categories][label][]" value="" /></div>	   
                                                 	<div style="width: 60%; padding-left: 1%;" class="field inline"><textarea name="settings[categories][desc][]"></textarea></div>
                                            		<div title="Delete Row" class="delete-row"></div>
                                           </div>
                                           <?php if(isset($post_types) && count($post_types) > 0) { ?>
                                           <?php		foreach($post_types as $cat_key => $cat_data) { ?>
                                           <div class="row" data-row-del-msg-check="Are you sure you wish to delete this custom setting and all it's groups?">
                                                    <div class="inline tab drag-row"></div>
                                                	<div style="width: 25%; padding-left: 1%;" class="field inline"><input type="text" class="required ninety" name="settings[categories][label][]" value="<?php echo $cat_data['label']?>" /></div>	   
                                                 	<div style="width: 60%; padding-left: 1%;" class="field inline"><textarea name="settings[categories][desc][]"><?php echo $cat_data['desc']?></textarea></div>
                                            		<div title="Delete Row" class="delete-row"></div>
                                                    <input type="hidden" class="row-pt-key" name="settings[categories][key][]" value="<?php echo $cat_key?>" />
                                           </div>
											<?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="add-row" style="display: block;"><a><b>+ <?php echo __('Add Category','kontrolwp')?></b></a></div>
                                </div>
                            </div>
                        </div>
                   </div>
                   <div class="item">
                   		<input type="submit" value="<?php echo __('Save Settings','kontrolwp')?>" class="button-primary" />
                   </div>
                   
                </div>
          </div>
        </div>
        </form>
      </div>
     </div>
</div>

 
<!-- Side Col -->
<div class="side-col inline">
	 <div class="section notification">
     	<div class="inside">
            <div class="title"></div>
            <div class="menu-item alert"><div class="text link"></div></div>
        </div>
    </div>
    
	 <div class="section">
     	<div class="inside">
            <div class="title"><?php echo __('Field Groups','kontrolwp')?></div>
            <div class="menu-item add">
            	<?php if(KONTROL_T && (10-$field_count) <= 0) { ?>
                	<div class="link"><a href="<?php echo APP_UPGRADE_URL?>" target="_blank"><?php echo __('Upgrade to the full edition!','kontrolwp')?></a></div>
                    <div class="desc"><?php echo sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d advanced custom fields. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'), 10)?></div>
                <?php }else{ ?>
                    <div class="link"><a href="<?php echo $controller_url?>/add" class="button-primary" style="font-weight: normal;"><?php echo __('Add new field group','kontrolwp')?></a></div>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <?php $this->renderElement('cs-side-col', array('field_count'=>$field_count, 'controller_url'=>$controller_url)); ?>
</div>
 