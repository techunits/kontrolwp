  <? 
  $menu_icon_url = isset($menu[6]) && $menu[6] != 'div' && !empty($menu[6]) && $menu[6] != 'none' ? $menu[6] : ''; 
  ?>
 
 <div id="<?=$menu_key?>" data-id="<?=isset($menu[5]) ? $menu[5]:''?>" class="row <?=isset($menu['visible']) && $menu['visible'] == 'false' ? 'hidden-row':''?> <?=isset($menu['deleted']) && $menu['deleted'] == 'true' ? 'deleted-row':''?>">
    <div class="inline tab drag-row"></div>
    	 <? if((!empty($menu_icon_url) && $menu[6] == 'div') || empty($menu_icon_url) || $menu[6] == 'none') { ?>
         	<div title="Icon" class="am-icon inline"></div>
         <? } ?>
          <? if(!empty($menu_icon_url)) { ?>
         	<div title="Icon" class="am-icon-image inline"><img src="<?=$menu_icon_url?>" /></div>
         <? } ?>
        <div title="Name" class="inline am-name">
            <b class="menu-name"><?=isset($menu[0]) ? $menu[0]:'New Menu Item'?></b>
        </div>
        <div title="Options" class="inline am-options">
            <img class="edit-field button-collapse expand" data-show-target="am-submenu-edit" alt="Edit" title="Edit" src="<?=URL_IMAGE?>icon-edit.png" style="cursor: pointer"> &nbsp;
            <img class="hide-field" alt="Hide" title="Hide" src="<?=URL_IMAGE?>icon-visible.png" style="cursor: pointer"> &nbsp;&nbsp;
            <img class="delete-field" alt="Delete" title="Delete" src="<?=URL_IMAGE?>icon-delete.png" style="cursor: pointer"> &nbsp;&nbsp;
           <? if($type == 'main') { ?> <div class="inline submenu-field"><img class="button-collapse expand" data-show-target="am-submenuoptions" alt="Hide" title="View Submenu" src="<?=URL_IMAGE?>icon-submenu.png" style="cursor: pointer"> <div style="position: relative; top: 4px;" class="inline">(<?=count($submenu)?>)</div></div> <? } ?>
        </div>
        <!-- Sub menus -->
        <div class="am-submenu am-submenu-edit section-content">
        	<div class="form-style">
                   <div class="item">
                        <div class="label"><?=__('Menu Title','kontrolwp')?> <span class="req-ast">*</span></div>
                        <div class="field"><input type="text" name="am[0][]" value="<?=isset($menu[0]) ? $menu[0]:__('New Menu Item','kontrolwp')?>" class="submenu-title required sixty" /></div>
                    </div>
                    <div class="item">
                       <div class="label"><?=__('URL')?> <span class="req-ast">*</span></div>
                       <div class="field"><input type="text" name="am[2][]" value="<?=isset($menu[2]) ? $menu[2]:''?>" class="required sixty" /></div>
                    </div>
                    <div class="item">
                       <div class="label"><?=__('Window Title','kontrolwp')?></div>
                       <div class="field"><input type="text" name="am[3][]" value="<?=isset($menu[3]) ? $menu[3]:''?>" class="sixty" /></div>
                    </div>
                    <? if($type == 'main') { ?>
                    <div class="item">
                       <div class="label"><?=__('CSS Classes','kontrolwp')?></div>
                       <div class="field"><input type="text" name="am[4][]" value="<?=isset($menu[4]) ? $menu[4]:'menu-top'?>" class="sixty" /></div>
                    </div>
                    <div class="item">
                       <div class="label"><?=__('Hook Name','kontrolwp')?></div>
                       <div class="field"><input type="text" name="am[5][]" value="<?=isset($menu[5]) ? $menu[5]:''?>" class="sixty" /></div>
                    </div>
                    <div class="item">
                        <div class="label"><?=__('Admin Menu','kontrolwp')?> <?=__('Icon')?></div>
                        <div class="field">
                       
                            <div class="kontrol-file-upload single-image" data-fileUploadType="image" data-fileReturnInputNameUpdate=".icon-image-upload" data-fileReturn="image_url" data-fileGetData='<?=http_build_query(array('user_id'=>$current_user->ID, 'post_id'=>0, 'data'=>array('image_preview_size'=>'thumbnail','image_dimensions_w'=>16,'image_dimensions_h'=>16,'image_dimensions'=>'enforce')))?>' data-fileListMax="1" data-multiple="false" data-maxSize="250" data-fileTypes="{'Images (*.jpg, *.jpeg, *.gif, *.png)':'*.jpg; *.jpeg; *.gif; *.png'}">
                                <input type="button" class="upload-el" value="<?=__('Upload Image','kontrolwp')?>" style="<?=(!empty($menu_icon_url)) ? 'display:none':''?>"  />
                                <ul class="upload-list">
                                 
                                        <li class="file remove" id="file-1">
                                            <? if(!empty($menu_icon_url)) { ?> <div class="remove-file"></div> <div class="file-image"><img src="<?=Kontrol_Tools::absolute_upload_path($menu_icon_url)?>"></div> <? } ?>
                                            <input type="hidden" class="icon-image-upload" name="am[6][]" value="<?=$menu_icon_url?>">
                                       </li>
                                </ul>
                            </div>
                        </div> 
                        <div class="desc"><?=__('Upload a custom menu icon. Size must be 16x16','kontrolwp')?>.</div>
                    </div>
                    <? }else{ ?>
                    		<input type="hidden" name="am[4][]" value="" />
                            <input type="hidden" name="am[5][]" value="" />
                            <input type="hidden" name="am[6][]" value="" />
                    <? } ?>
                    <div class="item">
                       <div class="label"><?=__('Required Permissions','kontrolwp')?> <span class="req-ast">*</span></div>
                       <div class="field">
                          <select name="am[1][]" class="sixty">
                          	  <optgroup label="Roles">
                              	<? foreach($role_list as $key_val => $name) { ?>
                                	<option value="<?=$key_val?>" <?=isset($menu[1]) && $menu[1] == $key_val ? 'selected="selected"':''?>><?=$name?></option>
                                <? } ?>
                              </optgroup>
                          	  <optgroup label="Capabilities">
                          	  <? foreach($cap_list as $cap_label => $access) { 
							  		if(!empty($access)) { ?>
                             	 <option value="<?=$cap_label?>" <?=isset($menu[1]) && $menu[1] == $cap_label ? 'selected="selected"':''?>><?=$cap_label?></option>
                              <? }
							  } ?>
                              </optgroup>
                          </select>
                      </div>
                    </div>
            </div>
        </div>
        
        <input type="hidden" class="row-visible" name="am[visible][]" value="<?=isset($menu['visible']) && $menu['visible'] == 'false' ? 'false':'true'?>" />
        <input type="hidden" class="row-deleted" name="am[deleted][]" value="<?=isset($menu['deleted']) && $menu['deleted'] == 'true' ? 'true':'false'?>" />
        <input type="hidden" class="row-type" name="am[type][]" value="<?=$type?>" />
        <input type="hidden" class="row-index" name="am[index][]" value="<?=(!empty($menu['key'])) ? $menu['key'] : $menu_key?>" />
        
		<? if($type == 'main') { ?>
        <div class="am-submenu am-submenuoptions">
        	<div class="section submenu-block">
                <div class="inside">
                    <div class="title"><?=__('Sub Menu','kontrolwp')?>
                    	<div class="title-options">
                           <div class="admin-menu-link admin-menu-add-row inline"><?=__('Insert New Row','kontrolwp')?></div>
                        </div>
                    </div>
                    <div class="rows sortable">
                        <? if(isset($submenu) && count($submenu) > 0) { 
                            foreach($submenu as $menu_key => $menu) { 
                                 if(isset($menu[4]) && $menu[4] == 'wp-menu-separator') { 
                                    $this->renderElement('am-row-seperator', array('type'=>'sub', 'current_user'=>$current_user, 'menu_key'=>$menu_key, 'menu'=>$menu, 'submenu'=>NULL, 'cap_list'=>$cap_list, 'role_list'=>$role_list)); 
                                 }else{
                                    $this->renderElement('am-row', array('type'=>'sub', 'current_user'=>$current_user, 'menu_key'=>$menu_key, 'menu'=>$menu, 'submenu'=>NULL, 'cap_list'=>$cap_list, 'role_list'=>$role_list)); 
                                 }
                            }
                        } ?>
                   </div>
                </div>
            </div>
        </div>
        <? } ?>
    
      
</div>