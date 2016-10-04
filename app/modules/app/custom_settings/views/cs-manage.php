<?
 global $current_user;
 get_currentuserinfo();
?>

<script type="text/javascript">

	window.addEvent('domready', function() {		
			// Mootools for managing the tables
			new kontrol_custom_settings_manage({
				'ajax_url':'<?=$controller_url?>' 
			});
			
			new kontrol_file_upload({
					'file_size_max': <?=Kontrol_Tools::return_post_max('bytes')?>,
					'app_path': '<?=URL_PLUGIN?>'
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
                <div class="title"><?=__('Custom Settings Groups','kontrolwp')?></div>
            </div>
     </div>
	<? 
	$group_count = 0;
	
	if(isset($post_types) && count($post_types) > 0) {
		

		foreach($post_types as $pt_key => $pt) { 
			if(isset($groups[$pt_key])) {
				$group_count++;
	?>
        <div class="section">
            <div class="inside">
                <div class="title"><?=$post_types[$pt_key]['label']?></div>
                <div class="rows sortable">
                    <? foreach($groups[$pt_key] as $group) { ?>
                    	<div id="<?=$group->id?>" data-id="<?=$group->id?>" data-group-id="<?=$group->group_id?>" sortAction="<?=$controller_url?>/updateGroupOrder/<?=$group->id?>/" class="row <?=empty($group->active) ? 'field-hidden':''?>">
                            <div class="inline tab drag-row"></div>
                            <div title="Name" style="width: 25%;  top: 4px;" class="inline cpt-name">
                                <b><a href="<?=$controller_url?>/edit/<?=$group->group_id?>"><?=$group->group_name?></a></b>
                            </div>
                            <div title="Field Count" style="width: 15%; top: 4px;" class="inline"><b><?=$group->field_count?></b> <?=__('Fields','kontrolwp')?></div>
                            <div title="Position" style="width: 15%; top: 4px;" class="inline"></div>
                            <div title="Options" style="width: 21%; text-align: center;" class="inline cpt-options">
                                <a href="<?=$controller_url?>/edit/<?=$group->group_id?>"><img class="edit-field" alt="<?=__('Edit','kontrolwp')?>" title="<?=__('Edit','kontrolwp')?>" src="<?=URL_IMAGE?>icon-edit.png" style="cursor: pointer"></a> &nbsp;
                                <img class="hide-field" alt="<?=__('Hide','kontrolwp')?>" title="<?=__('Hide','kontrolwp')?>" src="<?=URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
                                
                            </div>
                    	</div>
                    <? } ?>
                </div>
            </div>
        </div>
    <? 		}
		}
	} ?>
    
   <? if($group_count == 0) { ?>
   
  		<div class="section">
            <div class="inside">
                <div class="title"><?=__('Getting Started','kontrolwp')?></div>
                <div class="form-style">
                    <div class="item">
                        <div class="desc" style="font-size: 12px">
                        	<?=__("Custom settings allow you to use the power of our custom fields module to create your own sets of custom options for your CMS. These are highly useful for creating and storing information / images / files that don't need to be tied to any post.",'kontrolwp')?>
                        	<p>
							<?=__("As an example, say you need to display a company logo image across several different sections of your clients CMS. Instead of hard coding that image into several places, you can create a custom setting image field, upload the image there, then display that image anywhere across the site by simply retrieving that setting using the Kontrol <b>get_setting('insert-your-field-key')</b> function. Then to update the logo, just change the image in the custom settings page and the new logo is automatically shown across the whole site without the need to touch any HTML or code.",'kontrolwp')?>
                            </p>
                            <p>
                            <?=__("These custom settings allow you to create a very complete and flexible CMS solution for your clients.",'kontrolwp')?>
							</p>
                        </div>
                    </div> 
                 </div>
            </div>
        </div>
   <? } ?>
   
    
   </div>
     <div class="half inline">
      <div class="section">
      	 <form id="cs-settings-add" action="<?=$controller_url?>/saveSettings&noheader=true" method="POST">
     	<div class="inside">
            <div class="title"><?=__('Custom Settings Config','kontrolwp')?></div>
     			<div id="categories-settings-config" class="section-content collapsible-section">
                    <div class="form-style">
                    	<div>
                            <div class="item">
                                 <div class="label"><?=__('Admin Menu Enabled','kontrolwp')?></div>
                                 <div class="field">
                                    <select name="settings[enabled]" class="ninety">
                                    	<option value="false" <?=isset($cs_settings['enabled']) && $cs_settings['enabled'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                                        <option value="true" <?=isset($cs_settings['enabled']) && $cs_settings['enabled'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                                    </select>
                                 </div>
                                <div class="desc"><?=__('Enable access to the settings page via the admin menu','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div style="width:72%" class="inline">
                            <div class="item">
                                 <div class="label"><?=__('Admin Menu Name','kontrolwp')?></div>
                                 <div class="field"><input type="text" id="settings-name" name="settings[name]" value="<?=isset($cs_settings['name']) ? htmlentities($cs_settings['name'], ENT_QUOTES):'Site Options'?>" class="required ninety" /></div>
                                <div class="desc"><?=__('The label for the settings admin menu entry','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div style="width:25%" class="inline">
                            <div class="item show_ui_field">
                                <div class="label"><?=__('Admin Menu Icon','kontrolwp')?></div>
                                <div class="field">
                                
                                    <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputName="settings[menu_icon]" data-fileReturn="image_url" data-fileGetData='<?=http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'thumbnail','image_dimensions_w'=>16,'image_dimensions_h'=>16,'image_dimensions'=>'enforce')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="250" data-fileTypes="{'<?=__('Images')?> (*.jpg, *.jpeg, *.gif, *.png)':'*.jpg; *.jpeg; *.gif; *.png'}">
                                        <input type="button" class="upload-el" value="<?=__('Upload Image','kontrolwp')?>" style="<?=isset($cs_settings['menu_icon']) && !empty($cs_settings['menu_icon']) ? 'display:none':''?>"  />
                                        <ul class="upload-list">
                                         <? if(isset($cs_settings['menu_icon']) && !empty($cs_settings['menu_icon'])) { ?>
                                                <li class="file remove" id="file-1" style="margin-bottom: 0; padding-bottom: 0">
                                                    <div class="remove-file"></div>
                                                    <div class="file-image"><img src="<?=$cs_settings['menu_icon']?>"></div>
                                                    <input type="hidden" name="settings[menu_icon]" value="<?=$cs_settings['menu_icon']?>"></li>
                                         <? } ?>
                                        </ul>
                                        
                                    </div>
                                </div> 
                                <div class="desc">16x16 <?=__('menu icon','kontrolwp')?>.</div>
                            </div>
                        </div>
                        <div class="item">
                        	<div class="label" style="margin-top: 10px;"><?=__('Settings Categories','kontrolwp')?></div>
                        	<div id="settings-cats" data-auto-add-row="true" class="kontrol-smart-box">

                                <div class="section">
                                    <div class="inside">
                                        <div class="col-title">
                                        			<div class="inline" style="width: 49px"></div>
                                                     <div style="width: 25%; padding-left: 1%;" class="inline">
                                                        <div class="label"><?=__('Title')?> <span class="req-ast">*</span></div>
                                                        <div class="desc"><?=__('Category name and its submenu name','kontrolwp')?>.</div>
                                                    </div>
                                                    <div style="width: 60%; padding-left: 1%;" class="inline">
                                                        <div class="label"><?=__('Description / Instructions','kontrolwp')?></div>
                                                        <div class="desc"><?=__('Provide instructions or just a description of what these settings are used for on the site','kontrolwp')?>.</div>
                                                    </div>
                                        </div>
            
                                        <div class="rows sortable">
                                            <div class="row new-row">
                                                    <div class="inline tab drag-row"></div>
                                                	<div style="width: 25%; padding-left: 1%;" class="field inline"><input type="text" class="required ninety" name="settings[categories][label][]" value="" /></div>	   
                                                 	<div style="width: 60%; padding-left: 1%;" class="field inline"><textarea name="settings[categories][desc][]"></textarea></div>
                                            		<div title="Delete Row" class="delete-row"></div>
                                           </div>
                                           <? if(isset($post_types) && count($post_types) > 0) { ?>
                                           <?		foreach($post_types as $cat_key => $cat_data) { ?>
                                           <div class="row" data-row-del-msg-check="Are you sure you wish to delete this custom setting and all it's groups?">
                                                    <div class="inline tab drag-row"></div>
                                                	<div style="width: 25%; padding-left: 1%;" class="field inline"><input type="text" class="required ninety" name="settings[categories][label][]" value="<?=$cat_data['label']?>" /></div>	   
                                                 	<div style="width: 60%; padding-left: 1%;" class="field inline"><textarea name="settings[categories][desc][]"><?=$cat_data['desc']?></textarea></div>
                                            		<div title="Delete Row" class="delete-row"></div>
                                                    <input type="hidden" class="row-pt-key" name="settings[categories][key][]" value="<?=$cat_key?>" />
                                           </div>
											<? } ?>
                                        <? } ?>
                                    </div>
                                    <div class="add-row" style="display: block;"><a><b>+ <?=__('Add Category','kontrolwp')?></b></a></div>
                                </div>
                            </div>
                        </div>
                   </div>
                   <div class="item">
                   		<input type="submit" value="<?=__('Save Settings','kontrolwp')?>" class="button-primary" />
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
            <div class="title"><?=__('Field Groups','kontrolwp')?></div>
            <div class="menu-item add">
            	<? if(KONTROL_T && (10-$field_count) <= 0) { ?>
                	<div class="link"><a href="<?=APP_UPGRADE_URL?>" target="_blank"><?=__('Upgrade to the full edition!','kontrolwp')?></a></div>
                    <div class="desc"><?=sprintf(__("Well this is awkward. We're super sorry, but the limited edition of Kontrol only allows you %d advanced custom fields. The full version gives you unlimited + free upgrades to Kontrol and all future modules for the cost of less than your lunch. Bargain!",'kontrolwp'), 10)?></div>
                <? }else{ ?>
                    <div class="link"><a href="<?=$controller_url?>/add" class="button-primary" style="font-weight: normal;"><?=__('Add new field group','kontrolwp')?></a></div>
                <? } ?>
            </div>
        </div>
    </div>
    
    <?php $this->renderElement('cs-side-col', array('field_count'=>$field_count, 'controller_url'=>$controller_url)); ?>
</div>
 